import React, { useState, useEffect, useRef } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";

import VersionCheck from 'react-native-version-check';
import Modal from "react-native-modal";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import { WebView } from "react-native-webview";
import Axios from "../../utils/Axios";
import AlertModal from "../../components/AlertModal";

const Myinfoview = (props) => {
    
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

    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Mymain' });
        }
    }, [props.baseData.isLogin]);

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
                props.navigation.navigate("Chpasswd")
                setWeburl('');
            }
        }
    }
    
    function processnext()  {
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

    function logoutmsg(){
        setShowmsg({
            title:"로그아웃",
            message:"로그아웃 하시겠습니까?",
            confirmText:"로그아웃",
            cancelText:"닫기",
            movetype:1
        })
        setModalVisible(true);
    }

    function profunc()  {
        props.login({
            isLogin : false,
            userData : {},
        })
        props.navigation.navigate("Home");
    }

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"회원정보"} navigation={props.navigation}>
            <ScrollView>
                <View style={[glSt.px24,glSt.h54,glSt.jucenter,glSt.mb10]}>
                    <Text style={[glSt.c322A24,glSt.text14b]}>로그인 정보</Text>
                </View>
                <View style={[glSt.alcenter]}>
                    <View style={[glSt.mb12]}>
                        <Image source={Images.grade1}  style={{width:horizontalScale(60),height:horizontalScale(60)}} />
                    </View>
                    <View style={[glSt.mb12]}>
                        <Text style={[glSt.text12r,glSt.c6F6963]}>{props.baseData.userData.id}</Text>
                    </View>
                    <View style={[glSt.mb16]}>
                        <TouchableOpacity onPress={() => processnext()} style={[glSt.px22,glSt.py7,glSt.bgF6F4EE]}>
                            <Text style={[glSt.c6F6963,glSt.text12b]}>비밀번호 변경</Text>
                        </TouchableOpacity>
                    </View>
                </View>
                <View style={[glSt.px24]}>
                    <View style={[glSt.h54,glSt.jucenter,glSt.mb16]}>
                        <Text style={[glSt.c322A24,glSt.text14b]}>회원 정보</Text>
                    </View>
                    <View style={[glSt.mb8]}>
                        <Text style={[glSt.c322A24,glSt.text14m]}>성명</Text>
                    </View>
                     <View style={[glSt.bgE9E6E0,glSt.borderC0BCB6,glSt.h46,glSt.px16,glSt.alstart,glSt.jucenter,glSt.mb16]}>
                        <Text style={[glSt.text14r,glSt.c6F6963]}>{props.baseData.userData.name}</Text>  
                    </View>
                    <View style={[glSt.mb8]}>
                        <Text style={[glSt.c322A24,glSt.text14m]}>생년월일</Text>
                    </View>
                     <View style={[glSt.bgE9E6E0,glSt.borderC0BCB6,glSt.h46,glSt.px16,glSt.alstart,glSt.jucenter,glSt.mb16]}>
                        <Text style={[glSt.text14r,glSt.c6F6963]}>{props.baseData.userData.birthday}</Text>  
                    </View>
                    <View style={[glSt.mb8]}>
                        <Text style={[glSt.c322A24,glSt.text14m]}>휴대폰 번호</Text>
                    </View>
                     <View style={[glSt.bgE9E6E0,glSt.borderC0BCB6,glSt.h46,glSt.px16,glSt.alstart,glSt.jucenter,glSt.mb16]}>
                        <Text style={[glSt.text14r,glSt.c6F6963]}>{props.baseData.userData.cp}</Text>  
                    </View>
                </View>
            </ScrollView>
            <View style={[glSt.px24,glSt.pb24]}>
                <TouchableOpacity onPress={() => logoutmsg()} style={[glSt.flex,glSt.h54,glSt.mb24,glSt.alcenter,glSt.jubetween]}>
                    <Text style={[glSt.c322A24,glSt.text14b]}>로그아웃</Text>
                    <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                </TouchableOpacity>
                <TouchableOpacity onPress={() => props.navigateion.navigate("Memout")}>
                    <Text style={[glSt.cC0BCB6,glSt.text12b,{textDecorationLine: 'underline'}]}>회원탈퇴</Text>
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
            <AlertModal
                    visible={modalVisible}
                    oneButton={false}
                    title={showmsg.title}
                    message={showmsg.message}
                    confirmText={showmsg.confirmText}
                    cancelText={showmsg.cancelText}
                    onConfirm={() => {
                        console.log('이동 버튼 눌림');
                        profunc()
                    }}
                    onCancel={() => {
                        console.log('취소 버튼 눌림');
                        profunc(showmsg.movetype)
                    }}
                    onClose={() => setModalVisible(false)}
            />
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
)(Myinfoview);