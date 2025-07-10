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


const Joinstep4 = (props) => {
    


    return (
        <Layout havebottom={false} havetop={true} havnoback={true} navigation={props.navigation}>
            <View style={{position:"relative",height:verticalScale(4)}}>
                <View style={{backgroundColor:"#6F6963",opacity:0.1,height:verticalScale(4)}}></View>
                <View style={{width:"25%",backgroundColor:"#6F6963",height:verticalScale(4),position:"absolute",top:0,left:"75%",zIndex:1}}></View>
            </View>
            <KeyboardAwareScrollView contentContainerStyle={[glSt.px24,{ flexGrow: 1 }]}>
                <View style={[glSt.pt50]}>
                    <View style={[glSt.mb16,glSt.alcenter,glSt.mb24]}>
                        <Text style={[glSt.c322A24,glSt.text20b]}>그랑핸드의 회원이 되신 것을 환영합니다!</Text>
                    </View>
                    <View style={[glSt.py22,glSt.flex,glSt.alcenter,glSt.px16]}>
                        <View style={[glSt.mr18]}>
                            <Image source={Images.jicon1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                        <Text style={[glSt.c322A24,glSt.text14b]}>신규 가입 축하 쿠폰 10,000원</Text>
                    </View>
                    <View style={[glSt.py22,glSt.flex,glSt.alcenter,glSt.px16]}>
                        <View style={[glSt.mr18]}>
                            <Image source={Images.jicon2} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                        <Text style={[glSt.c322A24,glSt.text14b]}>출석 체크만 해도 적립 포인트를 드려요</Text>
                    </View>
                    <View style={[glSt.py22,glSt.flex,glSt.alcenter,glSt.px16]}>
                        <View style={[glSt.mr18]}>
                            <Image source={Images.jicon3} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                        <Text style={[glSt.c322A24,glSt.text14b]}>매일 만나는 행운! 최대 5,000원 포인트</Text>
                    </View>
                    <View style={[glSt.py22,glSt.flex,glSt.alcenter,glSt.px16]}>
                        <View style={[glSt.mr18]}>
                            <Image source={Images.jicon4} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                        <Text style={[glSt.c322A24,glSt.text14b]}>하나만 구매해도 전 제품 무료 배송</Text>
                    </View>
                </View>
            </KeyboardAwareScrollView>
            <View style={[glSt.px24,glSt.pb24]}>
                <TouchableOpacity onPress={() => props.navigation.navigate("Home")} style={[glSt.h46,glSt.bg322A24,glSt.mb24,glSt.alcenter,glSt.jucenter]}>
                    <Text style={[glSt.text14b,glSt.cFFFFFF]}>그랑핸드 시작하기</Text>
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
)(Joinstep4);