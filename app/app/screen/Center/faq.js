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

const Center = (props) => {
    
    const [ loading, setLoading ]  = useState(false);

    const [ cateidx, setCateidx ] = useState('');
    const [ catelist, setCatelist ] = useState([]);
    const [ datalist, setDatalst ] = useState([]);

    useFocusEffect(
        useCallback(() => {
            const fetchData = async () => {
                try {
                    const [cateRes, dataRes] = await Promise.all([
                        new Promise((resolve, reject) => Axios.get('&act=center&han=get_faqcate', resolve, reject)),
                        new Promise((resolve, reject) => Axios.get('&act=center&han=get_faq&cateidx='+cateidx, resolve, reject)),
                    ]);
                    
                    setCatelist(cateRes.datas);
                    setDatalst(dataRes.datas);

                } catch (e) {
                    console.error('API 중 오류 발생:', e);
                } finally {
                    setLoading(true);
                }
            };

            fetchData(); // 내부 async 함수 호출

            return () => {};
        }, [])
    );

    useEffect(() => {
        if(loading) {
            //setLoading(false);
            get_datalist();
        }
    },[cateidx]);

    async function get_datalist() {

        await Axios.get('&act=cont&han=get_faq&cateidx='+cateidx,
            (response) => {
                setDatalst(response.datas);
                setLoading(true);
            },
            (error) => console.log(error)
        );
    }

    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={"자주 묻는 질문"} navigation={props.navigation}>
                <View style={[glSt.h54,glSt.px24,glSt.flex,glSt.alcenter]}>
                    <TouchableOpacity onPress={() => setCateidx('')}>
                        <Text style={[glSt.mr16,glSt.text14b,cateidx === '' ? glSt.c322A24 : glSt.cC0BCB6]}>전체</Text>
                    </TouchableOpacity>
                    {catelist.map((item,index) => (
                    <TouchableOpacity key={"cate"+index} onPress={() => setCateidx(item.idx)}>
                        <Text style={[glSt.mr16,glSt.text14b,cateidx === item.idx ? glSt.c322A24 : glSt.cC0BCB6]}>{item.catename}</Text>
                    </TouchableOpacity>     
                    ))}
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
)(Center);