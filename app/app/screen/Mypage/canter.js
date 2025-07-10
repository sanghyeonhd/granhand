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


const Center = (props) => {


    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"고객센터"} navigation={props.navigation}>
            <View style={[glSt.px24,glSt.pt54]}>
                <TouchableOpacity onPress={() => props.navigation.navigate("Faq")} style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.h64]}>
                    <Text style={[glSt.c322A24,glSt.text16m]}>자주 묻는 질문</Text>
                    <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}}/>
                </TouchableOpacity>
                <TouchableOpacity style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.h64]}>
                    <Text style={[glSt.c322A24,glSt.text16m]}>채팅 문의</Text>
                    <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}}/>
                </TouchableOpacity>
                <TouchableOpacity onPress={() => props.navigation.navigate("Request")} style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.h64]}>
                    <Text style={[glSt.c322A24,glSt.text16m]}>제휴 문의</Text>
                    <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}}/>
                </TouchableOpacity>
                <TouchableOpacity onPress={() => props.navigation.navigate("Yak")} style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.h64]}>
                    <Text style={[glSt.c322A24,glSt.text16m]}>약관 및 정책</Text>
                    <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}}/>
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
)(Center);