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


const Config = (props) => {
    
    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Mymain' });
        }
    }, [props.baseData.isLogin]);

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"설정"} navigation={props.navigation}>
            <View style={[glSt.px24,glSt.pt54]}>
                <TouchableOpacity onPress={() => props.navigation.navigate("Alarmconfig")} style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.h64]}>
                    <Text style={[glSt.c322A24,glSt.text16m]}>알림 설정</Text>
                    <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}}/>
                </TouchableOpacity>
                <TouchableOpacity onPress={() => props.navigation.navigate("Lang")} style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.h64]}>
                    <Text style={[glSt.c322A24,glSt.text16m]}>언어 설정</Text>
                    <Text style={[glSt.cC0BCB6,glSt.text12b]}>한국어</Text>
                </TouchableOpacity>
                <TouchableOpacity style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.h64]}>
                    <View style={[glSt.flex,glSt.alcenter]}>
                        <View style={[glSt.mr4]}>
                            <Text style={[glSt.c322A24,glSt.text16m]}>버전 정보</Text>
                        </View>
                        <Text style={[glSt.c6F6963,glSt.text12m]}>1.0.1</Text>
                    </View>
                    
                    <Text style={[glSt.cC0BCB6,glSt.text12b]}>최신 버전 사용 중</Text>
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
)(Config);