import React, { useState, useEffect, useRef } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';

import { useFocusEffect } from '@react-navigation/native';

import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import Modal from 'react-native-modal';
import { WebView } from "react-native-webview";
import Axios from "../../utils/Axios";

const Joinstep3 = (props) => {
    
    const webView = useRef();

    const [ loading, setLoading ] = useState(true);
    const [ preidx, setPreidx ] = useState('');
    const [ isModalVisible , setIsModalVisible ] = useState(false);
    const [ weburl, setWeburl ]  = useState('');

    useFocusEffect(
        React.useCallback(() => {
            console.log(props.route.params);
            if(props.route.params?.preidx)   {
                setPreidx(props.route.params.preidx);
            }
        }, [props.route.params])
    );

    useEffect(() => {
        console.log(weburl)
        if(weburl != '') {
            setIsModalVisible(true);
        }
        
    }, [weburl]);

    function processnext()  {
        console.log('aaa')
        setWeburl("http://granhand.kro.kr/dream/start.php");
    }

    const handleOnMessage = (e) => {
        console.log("========================ddd");
        var data = e.nativeEvent.data;
        data = JSON.parse(data);
        //alert(data.type);
        console.log(data.type);
        if (data.type === "result") {
            setIsModalVisible(false);
            func_join(data);
        }
    }

    async function func_join(datas)    {
        const fdata = new FormData();

        fdata.append("pre_idx",preidx);
        fdata.append("ci",datas.ci);
        fdata.append("di",datas.di);
        fdata.append("name",datas.userName);
        fdata.append("birth",datas.userbirthday);
        fdata.append("sex",datas.usergender);
        fdata.append("cp",datas.userphone);
        

         await Axios.formpost('&act=member&han=appjoin',fdata,
            (response) => {
                console.log(response);
                if (response.res === 'ok') {
                   props.navigation.replace("Joinstep4")
                }   else    {
                    Alert.alert(response.resmsg);
                }
            },
            (error) => console.log(error)
        );
    }

    function displaySpinner() {
            return (
                <ActivityIndicator
                    color = {BaseColor.primaryColor}
                    size = "large"
                />
            );
    }
    
    const onShouldStartLoadWithRequest = (event) => {
            if (event.url.startsWith('http://') || event.url.startsWith('https://') || event.url.startsWith('about:blank')) {
                return true;
            }
            if (event.url.startsWith('sms:')) {
                Linking.openURL(event.url);
                return false;
            }
    
              if (Platform.OS === 'android') {
                SendIntentAndroid.openAppWithUri(event.url)
                  .then(isOpened => {
                    if (!isOpened) {
                      alert('앱 실행에 실패했습니다');
                    }
                  })
                  .catch(err => {
                    console.log(err);
                  });
              } else {
                Linking.openURL(event.url).catch(err => {
                  alert(
                    '앱 실행에 실패했습니다. 설치가 되어있지 않은 경우 설치하기 버튼을 눌러주세요.',
                  );
                });
                return false;
              }
    };

    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} navigation={props.navigation}>
                <View style={{position:"relative",height:verticalScale(4)}}>
                    <View style={{backgroundColor:"#6F6963",opacity:0.1,height:verticalScale(4)}}></View>
                    <View style={{width:"25%",backgroundColor:"#6F6963",height:verticalScale(4),position:"absolute",top:0,left:"50%",zIndex:1}}></View>
                </View>
                <KeyboardAwareScrollView contentContainerStyle={[glSt.px24,{ flexGrow: 1 }]}>
                    <View style={[glSt.pt50]}>
                        <View style={[glSt.mb16]}>
                            <Text style={[glSt.c322A24,glSt.text18b]}>본인인증을 진행해 주세요.</Text>
                        </View>
                        <View style={[glSt.mb30]}>
                            <Text style={[glSt.text14m,glSt.c6F6963]}>안전한 이용을 위해 최초 한 번 본인인증을 진행해요.</Text>
                        </View>
                    
                    </View>
                </KeyboardAwareScrollView>
                <View style={[glSt.px24,glSt.pb24]}>
                    <TouchableOpacity onPress={() => processnext()} style={[glSt.h46,glSt.bg322A24,glSt.mb24,glSt.alcenter,glSt.jucenter]}>
                        <Text style={[glSt.text14b,glSt.cFFFFFF]}>본인인증하고 가입하기</Text>
                    </TouchableOpacity>
                </View>
                <Modal isVisible={isModalVisible} style={{margin: 0,justifyContent:"center",alignItems:"center"}}  onBackdropPress={() => setIsModalVisible(false)}>
                    <View style={[glSt.bgFDFBF5,{flex:1,width:"100%",position:"relative"}]}>
                    {webView != '' &&
                    <WebView
                        ref={webView}
                        source={{uri:weburl}}
                        cacheEnabled={false}
                        originWhitelist={['*']}
                        javaScriptEnabled={true}
                        textZoom={100}
                        onMessage={handleOnMessage}
                        onShouldStartLoadWithRequest={event => {
                            return onShouldStartLoadWithRequest(event);
                        }}
                        renderLoading={() => {
                            return displaySpinner();
                        }}
                        >
                    </WebView>    
                    }
                    <TouchableOpacity onPress={() => {setWeburl(''); setIsModalVisible(false); }} style={{position:"absolute",top:horizontalScale(24),right:horizontalScale(24)}}>
                        <Image source={Images.icon_close} style={{width:horizontalScale(24),height:horizontalScale(24)}} ></Image>
                    </TouchableOpacity>
                    </View>
                </Modal>
            </Layout>
        );
    }   else{
        return (
                    <Layout havebottom={false} havetop={false} navigation={props.navigation}>
                        <View style={{flex:1,justifyContent:"center",alignItems:"center"}} >
                            <ActivityIndicator
                                size="small"
                                color={BaseColor.primaryColor}
                                style={{
                                    justifyContent: "center",
                                    alignItems: "center"
                                }}
                            />
                        </View>
                    </Layout>
        );
    }

    
};

  
const mapStateToProps = (state) => {
    return {
        baseData : state.auth
    };
};

const mapDispatchToProps = (dispatch) => {
    return {
        
		login: (idx) => {
			dispatch(AuthActions.login(idx));
		},
		logout: (idx) => {
			dispatch(AuthActions.logout(idx));
		}
    };
};

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(Joinstep3);