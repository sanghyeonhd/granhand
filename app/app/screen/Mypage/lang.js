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

const Lang = (props) => {
    
    const [ loading, setLoading ]  = useState(true);

    const [viewmode , setViewmode ] = useState(1)

    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={"언어 설정"} navigation={props.navigation}>
                <View style={[glSt.px24,glSt.pt54]}>
                    <TouchableOpacity style={[glSt.h64,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <Text style={[glSt.c322A24,glSt.text16m]}>한국어</Text>
                    </TouchableOpacity>
                    <TouchableOpacity style={[glSt.h64,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <Text style={[glSt.c322A24,glSt.text16m]}>English</Text>
                    </TouchableOpacity>
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
)(Lang);