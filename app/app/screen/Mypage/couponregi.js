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
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';
import AlertModal from "../../components/AlertModal";

const Couponregi = (props) => {
    
    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Mymain' });
        }
    }, [props.baseData.isLogin]);

    const [ id, setId ] = useState('');
    

    const [ iderr, setIderr ] = useState('');
   

    const [ idOk, setIdok ] = useState(false);
   
    const [modalVisible, setModalVisible ] = useState(false);
   

    useEffect(() => {
        if(id != '')    {
             setIderr('');
            setIdok(true);
        }
    }, [id]);    

    


    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"나의 쿠폰함"} navigation={props.navigation}>
            <KeyboardAwareScrollView contentContainerStyle={[{ flexGrow: 1 }]}>
            <View style={[glSt.px24]}>
                <View style={[glSt.h54,glSt.flex,glSt.alcenter]}>
                    <TouchableOpacity onPress={() => props.navigation.navigate("Coupon")} style={[glSt.mr16]}>
                        <Text style={[glSt.cC0BCB6,glSt.text14b]}>보유 쿠폰(0)</Text>
                    </TouchableOpacity>
                    <TouchableOpacity>
                        <Text style={[glSt.c322A24,glSt.text14b]}>쿠폰 등록</Text>
                    </TouchableOpacity>
                </View>
                <View style={[glSt.py16]}>
                    <View style={[]}>
                        <View style={glSt.mb8}>
                            <Text style={[glSt.text14m,glSt.c322A24]}>쿠폰번호</Text>
                        </View>
                        <View style={[glSt.h46,glSt.px16,iderr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                            <TextInput placeholder={"쿠폰번호를 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} value={id} onChangeText={text => setId(text) }  />
                        </View>
                        {iderr != '' &&
                        <View>
                            <Text style={[glSt.cFF3E24,glSt.text10m]}>{iderr}</Text>
                        </View>
                        }
                    </View>
                </View>
            </View>   
             
            </KeyboardAwareScrollView>
            <View style={[glSt.px24,glSt.pb24]}>
                <TouchableOpacity onPress={() => setModalVisible(true)} style={[(idOk) ? glSt.bg322A24 : glSt.bgDBD7D0,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                    <Text style={[glSt.text14b,glSt.cFFFFFF]}>쿠폰 등록</Text>
                </TouchableOpacity>
            </View>
            <AlertModal
                                visible={modalVisible}
                                oneButton={true}
                                title={"알림"}
                                message={"유효한 쿠폰번호가 아닙니다."}
                                confirmText={""}
                                cancelText={"닫기"}
                                onConfirm={() => {
                                    console.log('이동 버튼 눌림');
                                    profunc(showmsg.movetype)
                                }}
                                onCancel={() => {
                                    console.log('취소 버튼 눌림');
                                }}
                                onClose={() => setModalVisible(false)}
                        >
            
                        </AlertModal>
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
)(Couponregi);