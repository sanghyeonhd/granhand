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
import { verticalScale } from "../../utils/Scale";
import { Calendar } from "react-native-calendars";


const Attendance = (props) => {
    
    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Mymain' });
        }
    }, [props.baseData.isLogin]);

    const [selected, setSelected] = useState('');

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"출석 체크"} navigation={props.navigation}>
            <ScrollView>
                <View style={[glSt.px24,glSt.pt32]}>
                    <View style={{height:verticalScale(3),backgroundColor:"#6F6963"}}></View>
                    <View style={{marginBottom:verticalScale(32),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                        <View style={[glSt.px24,glSt.py24]}>
                            <Calendar
                                onDayPress={day => {
                                    setSelected(day.dateString);
                                }}
                                theme={{
                                backgroundColor: '#FDFBF5',
                                calendarBackground: '#FDFBF5',
                                textSectionTitleColor: '#b6c1cd',
                                selectedDayBackgroundColor: '#00adf5',
                                selectedDayTextColor: '#ffffff',
                                todayTextColor: '#00adf5',
                                dayTextColor: '#2d4150',
                                textDisabledColor: '#dd99ee'
                                }}
                                markedDates={{
                                    [selected]: {selected: true, disableTouchEvent: true, selectedDotColor: 'orange'}
                                }}
                            />
                        </View>
                    </View>
                    <View style={{marginBottom:verticalScale(32),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                        <View style={[glSt.px24,glSt.py24,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <View style={[{flex:1},glSt.alcenter]}>
                                <View style={[glSt.alcenter,glSt.mb4]}>
                                    <Text style={[glSt.cC0BCB6,glSt.text12b]}>누적 참여 횟수</Text>
                                </View>
                                <Text style={[glSt.c322A24,glSt.text18b]}>0일</Text>
                            </View>
                            <View style={{height:verticalScale(48),width:1,backgroundColor:"#E9E6E0"}}></View>
                            <View style={[{flex:1},glSt.alcenter]}>
                                <View style={[glSt.alcenter,glSt.mb4]}>
                                    <Text style={[glSt.cC0BCB6,glSt.text12b]}>누적 획득 포인트</Text>
                                </View>
                                <Text style={[glSt.c322A24,glSt.text18b]}>0일</Text>
                            </View>
                        </View>
                    </View>
                </View>
            </ScrollView>
            <View style={[glSt.px24]}>
                <TouchableOpacity  style={[glSt.h46,glSt.bg322A24,glSt.mb24,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                    <Text style={[glSt.text14b,glSt.cFFFFFF]}>출석 체크하기</Text>
                </TouchableOpacity>
                <TouchableOpacity  style={[glSt.h46,glSt.bgDBD7D0,glSt.mb24,glSt.alcenter,glSt.jucenter]}>
                    <Text style={[glSt.text14b,glSt.cFFFFFF]}>행운 뽑기</Text>
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
)(Attendance);