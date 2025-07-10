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

const Joinstep2 = (props) => {
    
    const [ id, setId ] = useState('');
    const [ passwd, setPasswd ] = useState('');
    const [ repasswd, setRepasswd ] = useState('');

    const [ iderr, setIderr ] = useState('');
    const [ passwderr, setPasswderr ] = useState('');
    const [ repasswderr, setRepasswderr ] = useState('');

    const [ idOk, setIdok ] = useState(false);
    const [ passwdOk, setPasswdOk ] = useState(false);
    const [ repasswdOk, setRepasswdOk ] = useState(false);
    

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

    useEffect(() => {
        
        if(passwd != repasswd)    {
            setRepasswderr('비밀번호가 서로 맞지 않습니다.');
            setRepasswdOk(false);   
        } else {
            setRepasswderr('');
            setRepasswdOk(true);
        }

    }, [repasswd]); 

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
        if(repasswd=='')  {
            setPasswderr("비밀번호확인을 입력하세요.");
            setPasswdOk(false);
            return;
        }
        func_login()
    }

    async function func_login() {

        await Axios.get('&act=member&han=prejoin&id='+id+'&passwd='+passwd,
            (response) => {
                console.log(response);
                if (response.res === 'ok') {
                   props.navigation.navigate("Joinstep3",{preidx:response.preidx})
                }   else    {
                    Alert.alert(response.resmsg);
                }
            },
            (error) => console.log(error)
        );
    }

    

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} navigation={props.navigation}>
            <View style={{position:"relative",height:verticalScale(4)}}>
                <View style={{backgroundColor:"#6F6963",opacity:0.1,height:verticalScale(4)}}></View>
                <View style={{width:"25%",backgroundColor:"#6F6963",height:verticalScale(4),position:"absolute",top:0,left:"25%",zIndex:1}}></View>
            </View>
            <KeyboardAwareScrollView contentContainerStyle={[glSt.px24,{ flexGrow: 1 }]}>
                <View style={[glSt.pt50]}>
                    <View style={[glSt.mb16]}>
                        <Text style={[glSt.c322A24,glSt.text18b]}>회원가입</Text>
                    </View>
                    <View style={[glSt.mb30]}>
                        <Text style={[glSt.text14m,glSt.c6F6963]}>로그인에 사용할 아이디와 비밀번호를 입력해 주세요.</Text>
                    </View>
                    <View style={[glSt.mb16]}>
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
                    <View style={[glSt.mb16]}>
                        <View style={glSt.mb8}>
                            <Text style={[glSt.text14m,glSt.c322A24]}>비밀번호</Text>
                        </View>
                        
                        <View style={[glSt.h46,glSt.px16,passwderr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                            <TextInput placeholder={"비밀번호 입력(영문, 숫자, 특수문자 포함 8~20 이내)"} style={[glSt.text14r,glSt.c322A24]} secureTextEntry={true} value={passwd} onChangeText={text => setPasswd(text) }  />
                        </View>
                        {passwderr != '' &&
                        <View>
                            <Text style={[glSt.cFF3E24,glSt.text10m]}>{passwderr}</Text>
                        </View>
                        }
                    </View>
                    <View>
                        <View style={[glSt.h46,glSt.px16,repasswderr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                            <TextInput placeholder={"비밀번호 확인"} style={[glSt.text14r,glSt.c322A24]} secureTextEntry={true} value={repasswd} onChangeText={text => setRepasswd(text) }  />
                        </View>
                        {repasswderr != '' &&
                        <View>
                            <Text style={[glSt.cFF3E24,glSt.text10m]}>{repasswderr}</Text>
                        </View>
                        }
                    </View>
                </View>
            </KeyboardAwareScrollView>
            <View style={[glSt.px24,glSt.pb24]}>
                <TouchableOpacity  onPress={() => check_login()} style={[(idOk && passwdOk && repasswdOk) ? glSt.bg322A24 : glSt.bgDBD7D0,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                    <Text style={[glSt.text14b,glSt.cFFFFFF]}>다음</Text>
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
)(Joinstep2);