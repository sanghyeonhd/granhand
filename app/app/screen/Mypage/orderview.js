import React, { useState, useEffect, useRef } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { AutoSizeRemoteImage, Image, Text } from "../../components/index";

import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import { useFocusEffect } from '@react-navigation/native';
import RBSheet from 'react-native-raw-bottom-sheet';

const Orderview = (props) => {
    
    const refRBSheet1 = useRef();

    const [ loading, setLoading ]  = useState(false);
    const [ idx, setIdx ] = useState();
    const [ data, setdata ] = useState([]);
    const [ datalist, setDatalist ] = useState([]);
    

    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Orders' });
        }
    }, [props.baseData.isLogin]);

    useFocusEffect(
            React.useCallback(() => {
                console.log(props.route.params);
                if(props.route.params?.idx)   {
                    setIdx(props.route.params.idx);
                }
            }, [props.route.params])
        );
    
    useEffect(() => {
        if(idx != 0){
            get_goods()
         }
    },[idx]);

    async function get_goods() {
        console.log("aaa");
        setLoading(false);
        await Axios.get('&act=order&han=get_ordersview&&mem_idx='+props.baseData.userData.idx+"&idx="+idx,
            (response) => {
                console.log(response.data);
                setDatalist(response.datalist);
                setdata(response.data);
                setTimeout(() => {
                    setLoading(true);
                }, 500); // 10000ms = 10초
            },
            (error) => console.log(error)
        );
    }

    if(loading) {
        return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"주문 상세 내역"} navigation={props.navigation}>
            <ScrollView>
                <View style={[glSt.px24]}>
                    <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb10]}>
                        <Text style={[glSt.c322A24,glSt.text10b]}>No. {data.orderno}</Text>
                        <Text style={[glSt.cC0BCB6,glSt.text10b]}>{data.odate}</Text>
                    </View>
                    <View style={[glSt.h54,glSt.jucenter]}>
                        <Text style={[glSt.c322A24,glSt.text14b]}>주문 상품 정보</Text>
                    </View>
                    <View>
                    {datalist.map((item2,index2) => (
                        <View key={"goods"+index2} style={{marginBottom:verticalScale(16),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                            <View style={[glSt.px16,glSt.py16]}>
                                <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb10]}>
                                    <Text></Text>
                                    
                                </View>
                                <View style={[glSt.flex,glSt.alstart,glSt.mb20]}>
                                    <TouchableOpacity style={[glSt.mr16]}>
                                        <AutoSizeRemoteImage uri={item2.simg1} basewidth={72} />
                                    </TouchableOpacity>
                                    <View>
                                        <View>
                                            <Text style={[glSt.c322A24,glSt.text12m]}>{item2.gname}</Text>
                                        </View>
                                        <View style={[glSt.mb12]}>
                                            <Text style={[glSt.c6F6963,glSt.text12r]}>{item2.gname_pre}</Text>
                                        </View>
                                        <View>
                                            <Text style={[glSt.c322A24,glSt.text14b]}>{item2.account/100}원</Text>
                                        </View>
                                    </View>
                                </View>
                            </View>
                        </View>
                    ))}
                    </View>
                    <View style={[glSt.h54,glSt.jucenter]}>
                        <Text style={[glSt.c322A24,glSt.text14b]}>배송지 정보</Text>
                    </View>
                    <View style={{marginBottom:verticalScale(16)}}>
                        <View style={[]}>
                            <View style={[glSt.flex,glSt.alcenter,glSt.mb8]}>
                                <View style={{width:horizontalScale(60)}}>
                                    <Text style={[glSt.text12r,glSt.cC0BCB6]}>받는 분</Text>    
                                </View>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>{data.del_name}</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.mb8]}>
                                <View style={{width:horizontalScale(60)}}>
                                    <Text style={[glSt.text12r,glSt.cC0BCB6]}>연락처</Text>    
                                </View>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>{data.del_cp}</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.mb8]}>
                                <View style={{width:horizontalScale(60)}}>
                                    <Text style={[glSt.text12r,glSt.cC0BCB6]}>주소</Text>    
                                </View>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>{data.del_addr1} {data.del_addr2}</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.mb8]}>
                                <View style={{width:horizontalScale(60)}}>
                                    <Text style={[glSt.text12r,glSt.cC0BCB6]}>요청사항</Text>    
                                </View>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>{data.memo}</Text>
                            </View>
                        </View>
                    </View>
                    <View style={[glSt.h54,glSt.jucenter]}>
                        <Text style={[glSt.c322A24,glSt.text14b]}>결제 정보</Text>
                    </View>
                    <View style={{marginBottom:verticalScale(24),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                        <View style={[glSt.px16,glSt.py16]}>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb8]}>
                                <Text style={[glSt.text12r,glSt.cC0BCB6]}>상품금액</Text>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>{data.account/100}원</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb8]}>
                                <Text style={[glSt.text12r,glSt.cC0BCB6]}>배송비</Text>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>0원</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb8]}>
                                <Text style={[glSt.text12r,glSt.cC0BCB6]}>쿠폰 할인</Text>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>0원</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb8]}>
                                <Text style={[glSt.text12r,glSt.cC0BCB6]}>포인트 사용</Text>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>0원</Text>
                            </View>
                            <View style={{borderTopWidth: 1,borderTopColor: '#E9E6E0',borderStyle: 'dashed',paddingTop:verticalScale(16)}}>
                                <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb8]}>
                                    <Text style={[glSt.text12b,glSt.c322A24]}>결제 금액</Text>
                                    <Text style={[glSt.text16b,glSt.c322A24]}>{data.account/100}원</Text>
                                </View>
                            </View>
                        </View>
                    </View>
                </View>
                
            </ScrollView>

        </Layout>
    );

    }  else{
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
)(Orderview);