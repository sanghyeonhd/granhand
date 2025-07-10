import React, { useState, useEffect, useCallback  } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import { View, TouchableOpacity, Dimensions, ScrollView, ImageBackground, ActivityIndicator, TouchableWithoutFeedback , Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import { useFocusEffect } from '@react-navigation/native';
import LinearGradient from 'react-native-linear-gradient';

import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";


const Journal = (props) => {

    const [ loading, setLoading ]  = useState(false);

    const [ cateidx, setCateidx ] = useState('');
    const [ catelist, setCatelist ] = useState([]);
    const [ datalist, setDatalst ] = useState([]);

    useFocusEffect(
        useCallback(() => {
            const fetchData = async () => {
                try {
                    const [cateRes, dataRes] = await Promise.all([
                        new Promise((resolve, reject) => Axios.get('&act=cont&han=get_journalcate', resolve, reject)),
                        new Promise((resolve, reject) => Axios.get('&act=cont&han=get_journal&cateidx='+cateidx, resolve, reject)),
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

        await Axios.get('&act=cont&han=get_journal&cateidx='+cateidx,
            (response) => {
                setDatalst(response.datas);
                setLoading(true);
            },
            (error) => console.log(error)
        );
    }
    
    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={"JOURNAL"} navigation={props.navigation}>
                <View style={[glSt.h54,glSt.px24,glSt.flex,glSt.alcenter]}>
                    <TouchableOpacity onPress={() => setCateidx('')}>
                        <Text style={[glSt.mr16,glSt.text14b,cateidx === '' ? glSt.c322A24 : glSt.cC0BCB6]}>All</Text>
                    </TouchableOpacity>
                    {catelist.map((item,index) => (
                    <TouchableOpacity key={"cate"+index} onPress={() => setCateidx(item.idx)}>
                        <Text style={[glSt.mr16,glSt.text14b,cateidx === item.idx ? glSt.c322A24 : glSt.cC0BCB6]}>{item.catename}</Text>
                    </TouchableOpacity>     
                    ))}
                </View>
                <ScrollView>
                    <View style={[glSt.px24]}>
                        {datalist.map((item,index) => (
                        <TouchableOpacity onPress={() => props.navigation.navigate("Journalv",{idx:item.idx})} key={"j"+index}>
                            <ImageBackground  source={{ uri: item.imgurl }}  style={{width:Dimensions.get("window").width - horizontalScale(48),height:(Dimensions.get("window").width - horizontalScale(48))*1.4,position:"relative",marginBottom:verticalScale(16)}} resizeMode="cover">
                                <LinearGradient colors={['rgba(0, 0, 0, 0.2)', 'rgba(0, 0, 0, 0.2)']} style={{position: 'absolute', top: 0, left: 0, right: 0, bottom: 0}} start={{ x: 0.5, y: 1 }} end={{ x: 0.5, y: 0 }} />
                                <View style={{position:"absolute",bottom:verticalScale(30),left:horizontalScale(16),right:horizontalScale(16)}}>
                                    <View style={[]}>
                                        <Text style={[glSt.cFFFFFF,glSt.text12b]}>#{item.catename}</Text>
                                    </View>
                                    <View style={[glSt.mb2]}>
                                        <Text style={[glSt.cFFFFFF,glSt.text16b]}>{item.subject}</Text>
                                    </View>
                                    <View style={[glSt.flex,glSt.alcenter]}>
                                        <Text style={[glSt.cFFFFFF,glSt.text12m]}>{item.wdate.substring(0, 10)} 조회 {item.readcount}</Text>
                                    </View>
                                </View>
                            </ImageBackground>
                        </TouchableOpacity >
                        ))}
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
)(Journal);