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


const Gift2 = (props) => {
    
    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Mymain' });
        }
    }, [props.baseData.isLogin]);

    const [viewmode, setViewmode ] = useState(1);

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"선물함"} navigation={props.navigation}>
            <View style={[glSt.px24,glSt.pt10,glSt.flex]}>
                <TouchableOpacity onPress={() => setViewmode(1)} style={[glSt.mr20]}>
                    <Text style={[viewmode == 1 ? glSt.cC0BCB6 : glSt.c6F6963,glSt.text12b]}>받은 선물</Text>
                </TouchableOpacity>
                <TouchableOpacity onPress={() => setViewmode(2)} style={[glSt.mr20]}>
                    <Text style={[viewmode == 2 ? glSt.cC0BCB6 : glSt.c6F6963,glSt.text12b]}>보낸 선물</Text>
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
)(Gift2);