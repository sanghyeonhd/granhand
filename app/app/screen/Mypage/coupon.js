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
import AlertModal from "../../components/AlertModal";


const Coupon = (props) => {

    const [ ordermode, setOrdermode ] = useState(1);
    const [ modalVisible, setModalVisible] = useState(false);
    
    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Mymain' });
        }
    }, [props.baseData.isLogin]);

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"나의 쿠폰함"} navigation={props.navigation}>
            <View style={[glSt.px24]}>
                <View style={[glSt.h54,glSt.flex,glSt.alcenter]}>
                    <TouchableOpacity style={[glSt.mr16]}>
                        <Text style={[glSt.c322A24,glSt.text14b]}>보유 쿠폰(0)</Text>
                    </TouchableOpacity>
                    <TouchableOpacity onPress={() => props.navigation.navigate("Couponregi")}>
                        <Text style={[glSt.cC0BCB6,glSt.text14b]}>쿠폰 등록</Text>
                    </TouchableOpacity>
                </View>
                <View style={[glSt.h42,glSt.flex,glSt.alcenter]}>
                    <TouchableOpacity onPress={() => setOrdermode(1)} style={[glSt.mr16]}>
                        <Text style={[ordermode == 1 ? glSt.c322A24 : glSt.cC0BCB6,glSt.text12b]}>최신순</Text>
                    </TouchableOpacity>
                    <TouchableOpacity onPress={() => setOrdermode(2)}>
                        <Text style={[ordermode == 2 ? glSt.c322A24 : glSt.cC0BCB6,glSt.text12b]}>유효기간순</Text>
                    </TouchableOpacity>
                </View>
                <View style={[glSt.alcenter,glSt.jucenter,glSt.pt54]}>
                    <Text style={[glSt.cC0BCB6,glSt.text14m]}>보유 중인 쿠폰이 없어요.</Text>
                </View>
                
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
)(Coupon);