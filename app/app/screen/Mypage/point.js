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
import { Calendar } from 'react-native-calendars';


const Point = (props) => {
    
    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Mymain' });
        }
    }, [props.baseData.isLogin]);

    const [viewmode, setViewmode ] = useState(1);

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"포인트"} navigation={props.navigation}>
            <View style={[glSt.px24]}>
                <View style={{marginBottom:verticalScale(32),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                    <View style={[glSt.px24,glSt.pt24]}>
                        <View style={[glSt.flex,glSt.alstart,glSt.jubetween,glSt.mb24]}>
                            <Text style={[glSt.c322A24,glSt.text12m]}>포인트</Text>
                            <Text style={[glSt.c322A24,glSt.text32b]}>0</Text>
                        </View>
                        <View style={{borderTopWidth: 1,borderColor: '#E9E6E0',borderStyle: 'dashed',height:0,marginBottom:verticalScale(16)}}/>
                        <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb16]}>
                            <Text style={[glSt.cC0BCB6,glSt.text12m]}>이번 달 소멸 예정 포인트</Text>
                            <Text style={[glSt.c322A24,glSt.text12m]}>0</Text>
                        </View>
                    </View>
                    
                </View>
                <View style={[glSt.h54,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                    <Text style={[glSt.c322A24,glSt.text14b]}>포인트 상세 내역</Text>
                    <TouchableOpacity style={[]}>
                        <Image source={Images.icon_q} style={{width:horizontalScale(24),height:horizontalScale(24)}} />  
                    </TouchableOpacity>

                </View>
                <View style={[glSt.h42,glSt.flex,glSt.alcenter]}>
                    <TouchableOpacity onPress={() => setViewmode(1)} style={[glSt.mr16]}>
                        <Text style={[viewmode == 1 ? glSt.c322A24 : glSt.cC0BCB6,glSt.text12b]}>전체</Text>
                    </TouchableOpacity>
                    <TouchableOpacity onPress={() => setViewmode(2)} style={[glSt.mr16]}>
                        <Text style={[viewmode == 2 ? glSt.c322A24 : glSt.cC0BCB6,glSt.text12b]}>적립</Text>
                    </TouchableOpacity>
                    <TouchableOpacity onPress={() => setViewmode(3)} style={[glSt.mr16]}>
                        <Text style={[viewmode == 3 ? glSt.c322A24 : glSt.cC0BCB6,glSt.text12b]}>사용</Text>
                    </TouchableOpacity>
                    <TouchableOpacity onPress={() => setViewmode(4)} style={[glSt.mr16]}>
                        <Text style={[viewmode == 4 ? glSt.c322A24 : glSt.cC0BCB6,glSt.text12b]}>소멸</Text>
                    </TouchableOpacity>
                </View>
                <View style={[glSt.alcenter,glSt.jucenter,glSt.pt54]}>
                    <Text style={[glSt.cC0BCB6,glSt.text14m]}>포인트 내역이 없어요.</Text>
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
)(Point);