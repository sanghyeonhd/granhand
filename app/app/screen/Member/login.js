import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';

import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import Axios from "../../utils/Axios";

const Login = (props) => {
    
    const [ id, setId ] = useState('');
    const [ passwd, setPasswd ] = useState('');

    const [ iderr, setIderr ] = useState('');
    const [ passwderr, setPasswderr ] = useState('');

    const [ idOk, setIdok ] = useState(false);
    const [ passwdOk, setPasswdOk ] = useState(false);

    const isEmail = (value) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(value);
    };

    const isValidPassword = (password) => {
        const regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=~`[\]{}|\\:;"'<>,.?/])[A-Za-z\d!@#$%^&*()_\-+=~`[\]{}|\\:;"'<>,.?/]{8,20}$/;
        return regex.test(password);
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
        if(passwd != '')    {
            if (!isValidPassword(passwd)) {
                setPasswderr("영문, 숫자, 특수문자를 포함한 8~20자여야 합니다.");
                setPasswdOk(false);
            } else {
                setPasswderr('');
                setPasswdOk(true);
            }
        }
    }, [passwd]); 

    function check_login()  {
        if(id=='')  {
            setIderr("아이디들 입력하세요.");
            setIdok(false);
            return;
        }
        if(passwd=='')  {
            setPasswderr("비밀번호를 입력하세요.");
            setPasswdOk(false);
            return;
        }
        func_login()
    }

    async function func_login() {
        await Axios.get("&act=member&han=login&id="+id+"&passwd="+passwd,
            (response) => {
                console.log(response);
                if (response.res === 'ok') {
                    props.login({
                        isLogin : true,
                        userData : response.datas,
                    })
                    props.navigation.navigate("Home");
                }   else    {
                    Alert.alert(response.resmsg);
                }
            },
            (error) => console.log(error)
        );
    }

    return (
        <Layout havebottom={false} havetop={false} navigation={props.navigation}>
            <TouchableOpacity onPress={() => props.navigation.navigate("Home")} style={[glSt.px24,glSt.h58,glSt.jucenter]}>
                <Image source={Images.applogo} style={{width:horizontalScale(109),height:horizontalScale(19)}}></Image>
            </TouchableOpacity>
            <KeyboardAwareScrollView contentContainerStyle={[glSt.px24,{ flexGrow: 1 }]}>
                <View style={[glSt.pt54,glSt.mb16]}>
                    <View style={glSt.mb8}>
                        <Text style={[glSt.text14m,glSt.c322A24]}>아이디</Text>
                    </View>
                    <View style={[glSt.h46,glSt.px16,iderr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                        <TextInput placeholder={"이메일을 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} value={id} onChangeText={text => setId(text) }  />
                    </View>
                    {iderr != '' &&
                    <View>
                        <Text style={[glSt.cFF3E24,glSt.text10m]}>{iderr}</Text>
                    </View>
                    }
                </View>
                <View style={[glSt.mb74]}>
                    <View style={glSt.mb8}>
                        <Text style={[glSt.text14m,glSt.c322A24]}>비밀번호</Text>
                    </View>
                    <View style={[glSt.h46,glSt.px16,passwderr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                        <TextInput placeholder={"비밀번호를 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} secureTextEntry={true} value={passwd} onChangeText={text => setPasswd(text) }  />
                    </View>
                    {passwderr != '' &&
                    <View>
                        <Text style={[glSt.cFF3E24,glSt.text10m]}>{passwderr}</Text>
                    </View>
                    }
                </View>
                <TouchableOpacity  onPress={() => check_login()} style={[(idOk && passwdOk) ? glSt.bg322A24 : glSt.bgDBD7D0,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                    <Text style={[glSt.text14b,glSt.cFFFFFF]}>로그인</Text>
                </TouchableOpacity>
                <TouchableOpacity  onPress={() => props.navigation.navigate("Joinstep1")} style={[glSt.borderC0BCB6,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                    <Text style={[glSt.text14b,glSt.c322A24]}>이메일 회원가입</Text>
                </TouchableOpacity>
                <View style={[glSt.flex,glSt.alcenter,glSt.jucenter,glSt.mb58]}>
                    <TouchableOpacity onPress={() => props.navigation.navigate("Findid")}>
                        <Text style={[glSt.text12m,glSt.c322A24]}>아이디 찾기</Text>
                    </TouchableOpacity>
                    <View style={[glSt.mx20,glSt.bgC0BCB6,{width:1,height:10}]}></View>
                    <TouchableOpacity onPress={() => props.navigation.navigate("Findpasswd")}>
                        <Text style={[glSt.text12m,glSt.c322A24]}>비밀번호 찾기</Text>
                    </TouchableOpacity>
                </View>
                <View style={[glSt.flex,glSt.alcenter,glSt.mb24]}>
                    <View style={{height:verticalScale(1),flex:1,backgroundColor:"#322A24",opacity:0.3}}></View>
                    <View style={[glSt.mx14]}>
                        <Text style={[glSt.text14m,glSt.c322A24]}>간편 로그인</Text>
                    </View>
                    <View style={{height:verticalScale(1),flex:1,backgroundColor:"#322A24",opacity:0.3}}></View>
                </View>
                <View style={[glSt.flex,glSt.alcenter,glSt.jucenter,glSt.mb24]}>
                    <TouchableOpacity>
                        <Image source={Images.icon_l_apple} style={{width:horizontalScale(48),height:horizontalScale(48),marginRight:horizontalScale(30)}} />
                    </TouchableOpacity>
                    <TouchableOpacity>
                        <Image source={Images.icon_l_google} style={{width:horizontalScale(48),height:horizontalScale(48),marginRight:horizontalScale(30)}} />
                    </TouchableOpacity>
                    <TouchableOpacity>
                        <Image source={Images.icon_l_naver} style={{width:horizontalScale(48),height:horizontalScale(48),marginRight:horizontalScale(30)}} />
                    </TouchableOpacity>
                    <TouchableOpacity>
                        <Image source={Images.icon_l_kakao} style={{width:horizontalScale(48),height:horizontalScale(48)}} />
                    </TouchableOpacity>
                </View>
            </KeyboardAwareScrollView>
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
)(Login);