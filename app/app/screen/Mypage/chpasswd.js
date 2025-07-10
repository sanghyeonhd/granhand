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
import AlertModal from "../../components/AlertModal";

const Chpasswd = (props) => {
    
    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Mymain' });
        }
    }, [props.baseData.isLogin]);

    const [ passwd, setPasswd ] = useState('');
    const [ passwderr, setPasswderr ] = useState('');
    const [ passwdOk, setPasswdOk ] = useState(false);

    const [ newpasswd, setNewpasswd ] = useState('');
    const [ newpasswderr, setNewpasswderr ] = useState('');
    const [ newpasswdOk, setNewpasswdOk ] = useState(false);

    const [ renewpasswd, setRenewpasswd ] = useState('');
    const [ renewpasswderr, setRenewpasswderr ] = useState('');
    const [ renewpasswdOk, setRenewpasswdOk ] = useState(false);

    const [ modalVisible , setModalVisible ] = useState(false);
    const [ showmsg , setShowmsg ] = useState({
        title:"",
        message:"",
        confirmText:"",
        cancelText:"",
        movetype:0
    })


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


    useEffect(() => {
        if(newpasswd != '')    {
            if (!isValidPassword(newpasswd)) {
                setNewpasswderr("영문, 숫자, 특수문자를 포함한 8~20자여야 합니다.");
                setNewpasswdOk(false);
            } else {
                if(passwd==newpasswd)  {
                    setNewpasswderr("햔재 비밀번호와 같이 사용 할수 없습니다.");
                    setNewpasswdOk(false);
                    return;
                }
                setNewpasswderr('');
                setNewpasswdOk(true);
            }
        }
    }, [newpasswd]); 

    useEffect(() => {
         if(newpasswd != renewpasswd)    {
            setRenewpasswderr('비밀번호가 서로 맞지 않습니다.');
            setRenewpasswdOk(false);   
        } else {
            setRenewpasswderr('');
            setRenewpasswdOk(true);
        }
    }, [renewpasswd]); 

    function check_login()  {
       
        if(passwd=='')  {
            setPasswderr("비밀번호를 입력하세요.");
            setPasswdOk(false);
            return;
        }
        
        if(newpasswd=='')  {
            setNewpasswderr("비밀번호를 입력하세요.");
            setNewpasswdOk(false);
            return;
        }
        if(renewpasswd=='')  {
            setRenewpasswderr("비밀번호를 입력하세요.");
            setPasswdOk(false);
            return;
        }
        
        func_login()
    }

    async function func_login() {
        console.log("&act=member&han=chpasswd&id="+props.baseData.userData.id+"&newpasswd="+newpasswd+"&passwd="+passwd)
        await Axios.get("&act=member&han=chpasswd&id="+props.baseData.userData.id+"&newpasswd="+newpasswd+"&passwd="+passwd,
            (response) => {
                console.log(response);
                if (response.res === 'ok') {
                    setShowmsg({
                        title:"비밀번호 수정완료",
                        message:"비밀번호가 변경되었습니다.",
                        confirmText:"닫기",
                        cancelText:"닫기",
                        movetype:1
                    })
                    setModalVisible(true);
                    
                }   else    {
                    setShowmsg({
                        title:"에러",
                        message:response.resmsg,
                        confirmText:"닫기",
                        cancelText:"닫기",
                        movetype:0
                    })
                    setModalVisible(true);
                }
            },
            (error) => console.log(error)
        );
    }

    function profunc(m) {
        if(m != 0){
            props.navigation.navigate("Myinfoview");
        }
    }

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"비밀번호 변경"} navigation={props.navigation}>
            <KeyboardAwareScrollView contentContainerStyle={[{ flexGrow: 1 }]}>
                <View style={[glSt.px24,glSt.pt54]}>
                    <View style={[glSt.mb16]}>
                        <View style={glSt.mb8}>
                            <Text style={[glSt.text14m,glSt.c322A24]}>현재 비밀번호</Text>
                        </View>
                        <View style={[glSt.h46,glSt.px16,passwderr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                            <TextInput placeholder={"현재 비밀번호를 입력해 주세요.."} style={[glSt.text14r,glSt.c322A24]} secureTextEntry={true} value={passwd} onChangeText={text => setPasswd(text) }  />
                        </View>
                        {passwderr != '' &&
                        <View>
                            <Text style={[glSt.cFF3E24,glSt.text10m]}>{passwderr}</Text>
                        </View>
                        }
                    </View>
                    <View style={[glSt.mb16]}>
                        <View style={glSt.mb8}>
                            <Text style={[glSt.text14m,glSt.c322A24]}>신규 비밀번호</Text>
                        </View>
                        <View style={[glSt.h46,glSt.px16,newpasswderr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                            <TextInput placeholder={"새 비밀번호를 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} secureTextEntry={true} value={newpasswd} onChangeText={text => setNewpasswd(text) }  />
                        </View>
                        {newpasswderr != '' &&
                        <View>
                            <Text style={[glSt.cFF3E24,glSt.text10m]}>{newpasswderr}</Text>
                        </View>
                        }
                    </View>
                    <View style={[glSt.mb16]}>
                        <View style={glSt.mb8}>
                            <Text style={[glSt.text14m,glSt.c322A24]}>신규 비밀번호 확인</Text>
                        </View>
                        <View style={[glSt.h46,glSt.px16,renewpasswderr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                            <TextInput placeholder={"새 비밀번호 확인해 주세요."} style={[glSt.text14r,glSt.c322A24]} secureTextEntry={true} value={renewpasswd} onChangeText={text => setRenewpasswd(text) }  />
                        </View>
                        {renewpasswderr != '' &&
                        <View>
                            <Text style={[glSt.cFF3E24,glSt.text10m]}>{renewpasswderr}</Text>
                        </View>
                        }
                    </View>
                </View>    
            </KeyboardAwareScrollView>
            <View style={[glSt.px24]}>
                <TouchableOpacity  onPress={() => check_login()} style={[(passwdOk && newpasswdOk && renewpasswdOk) ? glSt.bg322A24 : glSt.bgDBD7D0,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb24]}>
                    <Text style={[glSt.text14b,glSt.cFFFFFF]}>확인</Text>
                </TouchableOpacity>
            </View>
            <AlertModal
                    visible={modalVisible}
                    oneButton={true}
                    title={showmsg.title}
                    message={showmsg.message}
                    confirmText={showmsg.confirmText}
                    cancelText={showmsg.cancelText}
                    onConfirm={() => {
                        console.log('이동 버튼 눌림');
                        
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
)(Chpasswd);