import React, { useState, useEffect } from "react";
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
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';
import Axios from "../../utils/Axios";

const Myinfo = (props) => {
    
    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Mymain' });
        }
    }, [props.baseData.isLogin]);

    const [ passwd, setPasswd ] = useState('');
    const [ passwderr, setPasswderr ] = useState('');
    const [ passwdOk, setPasswdOk ] = useState(false);


    const isValidPassword = (password) => {
        const regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=~`[\]{}|\\:;"'<>,.?/])[A-Za-z\d!@#$%^&*()_\-+=~`[\]{}|\\:;"'<>,.?/]{8,20}$/;
        return regex.test(password);
    };
   

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
        if(passwd=='')  {
            setPasswderr("비밀번호를 입력하세요.");
            setPasswdOk(false);
            return;
        }
        func_login()
    }

    async function func_login() {
        console.log("&act=member&han=login&id="+props.baseData.userData.id+"&passwd="+passwd)
        await Axios.get("&act=member&han=login&id="+props.baseData.userData.id+"&passwd="+passwd,
            (response) => {
                console.log(response);
                if (response.res === 'ok') {
                   
                    props.navigation.navigate("Myinfoview");
                }   else    {
                    Alert.alert(response.resmsg);
                }
            },
            (error) => console.log(error)
        );
    }

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"회원정보"} navigation={props.navigation}>
            <KeyboardAwareScrollView contentContainerStyle={[{ flexGrow: 1 }]}>
                <View style={[glSt.px24,glSt.pt54]}>
                    <View style={[glSt.mb16]}>
                        <Text style={[glSt.c322A24,glSt.text18b]}>비밀번호 재확인</Text>
                    </View>
                    <View style={[glSt.mb40]}>
                        <Text style={[glSt.c6F6963,glSt.text14m]}>회원님의 정보를 안전하게 보호하기 위해 비밀번호를{"\n"}다시 한번 확인해 주세요.</Text>   
                    </View>
                    <View style={glSt.mb8}>
                        <Text style={[glSt.text14m,glSt.c322A24]}>아이디</Text>
                    </View>
                    <View style={[glSt.bgE9E6E0,glSt.borderC0BCB6,glSt.h46,glSt.px16,glSt.alstart,glSt.jucenter,glSt.mb24]}>
                        <Text style={[glSt.text14r,glSt.c6F6963]}>{props.baseData.userData.id}</Text>  
                    </View>
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
            </KeyboardAwareScrollView>
            <View style={[glSt.px24]}>
                <TouchableOpacity  onPress={() => check_login()} style={[(passwdOk) ? glSt.bg322A24 : glSt.bgDBD7D0,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb24]}>
                    <Text style={[glSt.text14b,glSt.cFFFFFF]}>확인</Text>
                </TouchableOpacity>
            </View>
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
)(Myinfo);