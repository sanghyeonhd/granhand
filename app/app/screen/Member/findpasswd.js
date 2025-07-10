import React, { useState, useEffect, useRef } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';

import Modal from "react-native-modal";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import { WebView } from "react-native-webview";
import Axios from "../../utils/Axios";
import AlertModal from "../../components/AlertModal";


const Findpasswd = (props) => {
    
    const [ id, setId ] = useState('');
    const [ iderr, setIderr ] = useState('');
    const [ idOk, setIdok ] = useState(false);

    const webView = useRef();
    const [ isModalVisible , setIsModalVisible ] = useState(false);
    const [ weburl, setWeburl ]  = useState('');
        
    const [ modalVisible , setModalVisible ] = useState(false);
    const [ showmsg , setShowmsg ] = useState({
            title:"",
            message:"",
            confirmText:"",
            cancelText:"",
            movetype:0
    })

    const isEmail = (value) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(value);
    };

    useEffect(() => {
         if(id != '')    {
             if (!isEmail(id)) {
                setIderr("아이디는 이메일 형식으로 입력하세요.");
                setIdok(false);
            } else {
                setIderr('');
                setIdok(true);
            }
        }
    }, [id]);   
    
         useEffect(() => {
                    console.log(weburl)
                    if(weburl != '') {
                        setIsModalVisible(true);
                    }
                    
        }, [weburl]);
        
        const handleOnMessage = (e) => {
                console.log("========================ddd");
                var data = e.nativeEvent.data;
                data = JSON.parse(data);
                //alert(data.type);
                console.log(data.type);
                if (data.type === "result") {
                    setIsModalVisible(false);
                    if(data.resultCode == "2000")   {
                        props.navigation.navigate("Findpasswdshow",{cp:data.userphone,id:id})
                        setWeburl('');
                    }
                }
        }
            
        function processnext()  {
             if(id=='')  {
                setIderr("아이디들 입력하세요.");
                setIdok(false);
                return;
            }
            console.log('aaa')
            setWeburl("http://granhand.kro.kr/dream/start.php");
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
        
            
            function profunc()  {
                props.login({
                    isLogin : false,
                    userData : {},
                })
                props.navigation.navigate("Home");
            }

    return (
        <Layout havebottom={false} havetop={true} navigation={props.navigation}>
            <KeyboardAwareScrollView contentContainerStyle={[glSt.px24,{ flexGrow: 1 }]}>
                <View style={[glSt.pt50]}>
                    <View style={[glSt.mb16]}>
                        <Text style={[glSt.c322A24,glSt.text18b]}>비밀번호 찾기</Text>
                    </View>
                    <View style={[]}>
                        <Text style={[glSt.text14m,glSt.c6F6963]}>가입한 아이디(이메일)를 입력해 주세요.</Text>
                    </View>
                     <View style={[glSt.mb32]}>
                        <Text style={[glSt.text14m,glSt.c6F6963]}>휴대폰 본인인증을 통해 아이디(이메일)를 확인합니다.</Text>
                    </View>
                    <View style={[glSt.mb16]}>
                        <View style={glSt.mb8}>
                            <Text style={[glSt.text14m,glSt.c322A24]}>아이디</Text>
                        </View>
                        <View style={[glSt.borderC0BCB6,glSt.h46,glSt.px16]}>
                            <TextInput placeholder={"이메일을 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} value={id} onChangeText={text => setId(text) }  />
                        </View>
                    </View>
                </View>
            </KeyboardAwareScrollView>
            <View style={[glSt.px24]}>
                <View style={[glSt.mb32,glSt.px16,glSt.py16,glSt.bgF6F4EE]}>
                    <View>
                        <Text style={[glSt.text10m,glSt.c6F6963]}>SNS 계정으로 가입하신 회원님은 비밀번호를 재설정할 수 없습니다.</Text>
                    </View>
                    <View>
                        <Text style={[glSt.text10m,glSt.c6F6963]}>로그인 화면에서 ‘간편 로그인' 하신 후 이용해 주세요.</Text>
                    </View>
                </View>
                <TouchableOpacity onPress={() => processnext()} style={[(idOk) ? glSt.bg322A24 : glSt.bgDBD7D0,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                    <Text style={[glSt.text14b,glSt.cFFFFFF]}>본인인증 하기</Text>
                </TouchableOpacity>
            </View>
            <Modal isVisible={isModalVisible} style={{margin: 0,justifyContent:"center",alignItems:"center"}}  onBackdropPress={() => setIsModalVisible(false)}>
                    <View style={[glSt.bgFDFBF5,{flex:1,width:"100%",position:"relative"}]}>
                    {weburl != '' &&
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
)(Findpasswd);