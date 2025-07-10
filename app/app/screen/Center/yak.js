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

const Yak = (props) => {
    
    const [ loading, setLoading ]  = useState(true);

    const [viewmode , setViewmode ] = useState(1)

    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={"약관 및 정책"} navigation={props.navigation}>
                <View style={[glSt.h54,glSt.px24,glSt.flex,glSt.alcenter]}>
                    <TouchableOpacity onPress={() => setViewmode(1)}>
                        <Text style={[glSt.mr16,glSt.text14b,viewmode === 1 ? glSt.c322A24 : glSt.cC0BCB6]}>이용약관</Text>
                    </TouchableOpacity>
                    
                    <TouchableOpacity onPress={() => setViewmode(2)}>
                        <Text style={[glSt.mr16,glSt.text14b,viewmode === 2 ? glSt.c322A24 : glSt.cC0BCB6]}>개인정보처리방침</Text>
                    </TouchableOpacity>     
                </View>
                <ScrollView>
                    <View style={[glSt.px24]}>
                       
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
)(Yak);