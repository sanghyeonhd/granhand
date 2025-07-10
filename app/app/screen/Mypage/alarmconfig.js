import React, { useState, useEffect, useCallback  } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";

import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import { useFocusEffect } from '@react-navigation/native';
import SwitchToggle from "react-native-switch-toggle";

const Alarmconfig = (props) => {
    
    const [ loading, setLoading ]  = useState(true);

    const [viewmode , setViewmode ] = useState(1)

    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={"알림 설정"} navigation={props.navigation}>
                <View style={{flex:1}}>
                    <View style={[glSt.pt54,glSt.mb60,glSt.flex,glSt.alcenter,glSt.jubetween,glSt.px24]}>
                        <View>
                            <View>
                                <Text style={[glSt.text14b,glSt.c322A24]}>서비스 알림</Text>
                            </View>
                            <Text style={[glSt.text10m,glSt.cC0BCB6]}>푸시 알림은 기기의 ‘설정 &gt;그랑핸드&gt;알림'에서 설정 가능합니다.</Text>
                        </View>
                        <View>
                            <SwitchToggle
                            switchOn={true}
                            circleColorOff="white"
                            circleColorOn="white"
                            backgroundColorOn="#322A24"
                            backgroundColorOff="#E9E6E0"
                            containerStyle={{
                                width: 40,
                                height: 24,
                                borderRadius: 25,
                                padding: 3,
                            }}
                            circleStyle={{
                                width: 18,
                                height: 18,
                                borderRadius: 20,
                                backgroundColor: 'white',
                            }}
                            />
                        </View>
                    </View>
                    <View style={[glSt.mb14,glSt.flex,glSt.alcenter,glSt.jubetween,glSt.px24]}>
                        <View>
                            <View>
                                <Text style={[glSt.text14b,glSt.c322A24]}>혜택 정보 알림</Text>
                            </View>
                            <Text style={[glSt.text12m,glSt.cC0BCB6]}>그랑핸드 회원을 위한 할인 소식, 쿠폰 등 혜택 정보를 알려드립니다.</Text>
                        </View>
                        <View>

                        </View>
                    </View>
                    <View style={[glSt.h64,glSt.flex,glSt.alcenter,glSt.jubetween,glSt.px24]}>
                        <View>
                            <Text style={[glSt.text14b,glSt.c322A24]}>앱 푸시</Text>
                        </View>
                        <View>
                           <SwitchToggle
                            switchOn={true}
                            circleColorOff="white"
                            circleColorOn="white"
                            backgroundColorOn="#322A24"
                            backgroundColorOff="#E9E6E0"
                            containerStyle={{
                                width: 40,
                                height: 24,
                                borderRadius: 25,
                                padding: 3,
                            }}
                            circleStyle={{
                                width: 18,
                                height: 18,
                                borderRadius: 20,
                                backgroundColor: 'white',
                            }}
                        />     
                        </View>
                    </View>
                    <View style={[glSt.h64,glSt.flex,glSt.alcenter,glSt.jubetween,glSt.px24]}>
                        <View>
                            <Text style={[glSt.text14b,glSt.c322A24]}>SMS</Text>
                        </View>
                        <View>
                            <SwitchToggle
                            switchOn={true}
                            circleColorOff="white"
                            circleColorOn="white"
                            backgroundColorOn="#322A24"
                            backgroundColorOff="#E9E6E0"
                            containerStyle={{
                                width: 40,
                                height: 24,
                                borderRadius: 25,
                                padding: 3,
                            }}
                            circleStyle={{
                                width: 18,
                                height: 18,
                                borderRadius: 20,
                                backgroundColor: 'white',
                            }}
                        />
                        </View>
                    </View>
                </View>
                <View style={[glSt.mb60,glSt.alcenter]}>
                    <Text style={[glSt.cDBD7D0,glSt.text12b]}>그랑핸드는 쇼핑에 도움이 되는 정보만 제공합니다.</Text>
                </View>
            </Layout>
        );
    }   else    {
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
)(Alarmconfig);