import React, { useState, useEffect, useCallback } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  View, TouchableOpacity, Dimensions, ScrollView, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text, AutoSizeRemoteImage } from "../../components/index";
import { useFocusEffect } from '@react-navigation/native';
import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";


const Gradinfo = (props) => {
    
    const [ loading, setLoading ]  = useState(true);
    
   

    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={"등급 안내"} navigation={props.navigation}>
                <ScrollView>
                    <View style={[glSt.px24]}>
                        <View style={{marginTop:verticalScale(10),marginBottom:verticalScale(32),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                            <View style={[glSt.py16,glSt.px24]}>
                                <View style={[glSt.alcenter,glSt.jucente,glSt.mb10]}>
                                    <Image source={Images.grade} style={{height:horizontalScale(60),width:horizontalScale(60)}} />
                                </View>
                                <View style={[glSt.mb4,glSt.alcenter]}>
                                    <Text style={[glSt.c322A24,glSt.text14b]}>{props.baseData.userData.name}님</Text>
                                </View>
                                <View style={[glSt.pb16,glSt.mb16,glSt.alcenter,{borderBottomColor:"#E9E6E0",borderBottomWidth:1,borderStyle: 'dashed'}]}>
                                    <Text style={[glSt.cC0BCB6,glSt.text14m]}>현재 등급은 Basic 입니다.</Text>
                                </View>
                            </View>
                        </View>    
                        <View style={[glSt.mb30]}>
                            <Text style={[glSt.c322A24,glSt.text14b]}>등급 혜택 안내</Text>
                        </View>
                        <View style={[glSt.mb30]}>
                            <Text style={[glSt.c322A24,glSt.text14b]}>등급 혜택 안내</Text>
                        </View>
                        <View style={[glSt.mb30]}>
                            <Text style={[glSt.c322A24,glSt.text14b]}>회원 등급 혜택 안내</Text>
                        </View>
                    </View>
                </ScrollView>
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
)(Gradinfo);