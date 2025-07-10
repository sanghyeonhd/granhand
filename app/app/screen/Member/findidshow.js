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
import { useFocusEffect } from '@react-navigation/native';

const Findidshow = (props) => {
    
    

    const [ loading , setLoading ] = useState(false);
    const [ cp, setCp ]  = useState('');
    const [ data, setData ] = useState('');
    
    useFocusEffect(
        React.useCallback(() => {
                console.log(props.route.params);
                if(props.route.params?.cp)   {
                    setCp(props.route.params.cp);
                }
        }, [props.route.params])
    );
    
    useEffect(() => {
        if(cp != ''){
            get_event()
        }
    },[cp]);

    async function get_event() {
        setLoading(false);
        await Axios.get('&act=member&han=checkmember&cp='+cp,
            (response) => {

                if(response.res == 'ok')    {
                    setData(response.datas);
                    console.log(response.datas);
                } 
                
                setTimeout(() => {
                        setLoading(true);
                }, 500); // 10000ms = 10초
            },
            (error) => console.log(error)
        );
    }

    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={""} navigation={props.navigation}>
                {data == '' ?
                <View>

                </View>
                :
                <>
                <KeyboardAwareScrollView contentContainerStyle={[glSt.px24,{ flexGrow: 1 }]}>
                    
                    <View style={[glSt.pt50]}>
                        <View style={[glSt.mb40]}>
                            <Text style={[glSt.c322A24,glSt.text18b]}>계정을 찾았습니다.</Text>
                        </View>
                        <View style={[glSt.mb24,glSt.py16,glSt.bgF6F4EE]}>
                            <View style={[glSt.mb4,glSt.alcenter]}>
                                <Text style={[glSt.text14b,glSt.c6F6963]}>{data.id}</Text>
                            </View>
                            <View style={[glSt.alcenter]}>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>{data.signdate.substring(0,10)} 가입</Text>
                            </View>
                        </View>
                     </View>
                   
                </KeyboardAwareScrollView>
                <View style={[glSt.px24]}>
                    <View style={[glSt.mb32,glSt.px16,glSt.py16,glSt.bgF6F4EE]}>
                        <View>
                            <Text style={[glSt.text10m,glSt.c6F6963]}>SNS 계정으로 가입하신 회원님은 아이디 찾기가 불가능합니다.</Text>
                        </View>
                        <View>
                            <Text style={[glSt.text10m,glSt.c6F6963]}>가입하신 계정이 기억나지 않을 경우 hello@granhand.com로 문의 하시기 바랍니다.</Text>
                        </View>
                    </View>
                    <TouchableOpacity onPress={() => props.navigation.navigate("Login")} style={[glSt.h46,glSt.bg322A24,glSt.mb24,glSt.alcenter,glSt.jucenter]}>
                        <Text style={[glSt.text14b,glSt.cFFFFFF]}>로그인</Text>
                    </TouchableOpacity>
                </View>
                </>
                }            
            </Layout>
        );
    }   else{
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
)(Findidshow);