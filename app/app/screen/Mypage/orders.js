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

const Orders = (props) => {
    
    const refRBSheet1 = useRef();

    const [ loading, setLoading ]  = useState(false);
    const [ data, setdata ] = useState([]);
    const [ datalist, setDatalist ] = useState([]);
    const [ obdata, setobdata ] = useState({
        ob:1,
        obstr:'최근1년'
    })
    const [ sdate, setSdate ]  = useState('');
    const [ edate, setEdate ]  = useState('');
    
    useEffect(() => {
        if(obdata.ob == 1)   {
            setSdate(getPastDate(1, 'years'));
        }
        if(obdata.ob == 2)   {
            setSdate(getPastDate(7, 'days'));
        }
        if(obdata.ob == 3)   {
            setSdate(getPastDate(1, 'months'))
        }
        if(obdata.ob == 4)   {
            setSdate(getPastDate(3, 'months'))
        }
        const today = new Date().toISOString().split('T')[0];
        setEdate(today);
    }, [obdata]);

    function getPastDate(offset, unit = 'days') {
        const date = new Date();
        switch (unit) {
            case 'days':
                date.setDate(date.getDate() - offset);
                break;
            case 'months':
                date.setMonth(date.getMonth() - offset);
                break;
            case 'years':
                date.setFullYear(date.getFullYear() - offset);
                break;
        }
        return date.toISOString().split('T')[0]; // YYYY-MM-DD 형식으로 반환
    }

    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Orders' });
        }
    }, [props.baseData.isLogin]);

    useFocusEffect(
        React.useCallback(() => {
            if(props.baseData.isLogin){
                 get_goods()
            }
        }, [])
    );

    async function get_goods() {
        console.log("aaa");
        setLoading(false);
        await Axios.get('&act=order&han=get_orders&&mem_idx='+props.baseData.userData.idx+"&limit="+obdata.ob,
            (response) => {
                console.log(response.cart);
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
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"주문 내역"} navigation={props.navigation}>
            <View style={[glSt.px24,glSt.pt10,glSt.flex,glSt.h58,glSt.alcenter,glSt.jubetween]}>
                <View style={[glSt.flex,glSt.alcenter]}    >
                    <View style={[glSt.mr10]}>
                        <Text style={[glSt.c322A24,glSt.text14b]}>전체</Text>
                    </View>
                    <Text style={[glSt.c6F6963,glSt.text10b]}>{obdata.obstr}</Text>
                </View>
                <TouchableOpacity onPress={() => refRBSheet1.current.open()}>
                    <Text style={[glSt.cC0BCB6,glSt.text12b]}>기간설정</Text>
                </TouchableOpacity>
            </View>
            <View style={[glSt.px24]}>
                <View style={{marginBottom:verticalScale(25),paddingHorizontal:horizontalScale(13),paddingVertical:verticalScale(17),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                    <View style={[glSt.flex,glSt.alcenter,glSt.jubetween]}    >
                        <TouchableOpacity style={[glSt.alcenter]}>
                            <View style={[glSt.mb10]}>
                                <Text style={[data.d1 == 0 ? glSt.cE9E6E0 : glSt.c322A24,glSt.text16b]}>{data.d1}</Text>
                            </View>
                            <Text style={[glSt.c6F6963,glSt.text12m]}>입금/결제</Text>
                        </TouchableOpacity>
                        <TouchableOpacity style={[glSt.alcenter]}>
                            <View style={[glSt.mb10]}>
                                <Text style={[data.d2 == 0 ? glSt.cE9E6E0 : glSt.c322A24,glSt.text16b]}>{data.d2}</Text>
                            </View>
                            <Text style={[glSt.c6F6963,glSt.text12m]}>배송준비</Text>
                        </TouchableOpacity>
                        <TouchableOpacity style={[glSt.alcenter]}>
                            <View style={[glSt.mb10]}>
                                <Text style={[data.d3 == 0 ? glSt.cE9E6E0 : glSt.c322A24,glSt.text16b]}>{data.d3}</Text>
                            </View>
                            <Text style={[glSt.c6F6963,glSt.text12m]}>배송중</Text>
                        </TouchableOpacity>
                        <TouchableOpacity style={[glSt.alcenter]}>
                            <View style={[glSt.mb10]}>
                                <Text style={[data.d4 == 0 ? glSt.cE9E6E0 : glSt.c322A24,glSt.text16b]}>{data.d4}</Text>
                            </View>
                            <Text style={[glSt.c6F6963,glSt.text12m]}>배송완료</Text>
                        </TouchableOpacity>
                        <TouchableOpacity style={[glSt.alcenter]}>
                            <View style={[glSt.mb10]}>
                                <Text style={[data.d5 == 0 ? glSt.cE9E6E0 : glSt.c322A24,glSt.text16b]}>{data.d5}</Text>
                            </View>
                            <Text style={[glSt.c6F6963,glSt.text12m]}>구매확정</Text>
                        </TouchableOpacity>
                    </View>
                </View>
            </View>
            {datalist.length == 0 &&
            <View style={[glSt.alcenter,glSt.jucenter,glSt.pt54]}>
                <Text style={[glSt.cC0BCB6,glSt.text14m]}>주문한 상품 내역이 없어요.</Text>
            </View>
            }
            <ScrollView>
                <View style={[glSt.px24]}>
                    {datalist.map((item,index) =>(
                    <View key={"or"+index}>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Orderview",{idx:item.idx})} style={[glSt.h54,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.flex,glSt.alcenter]}>
                                <Text style={[glSt.c322A24,glSt.text14b]}>{item.odate.substring(0,10)}</Text>
                                {item.isgift == 'Y' &&
                                <Image source={Images.icon_gift   } style={{width:horizontalScale(24),height:horizontalScale(24),marginHorizontal:horizontalScale(10)}} />    
                                }
                            </View>
                            
                            <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        {item.goodslist.map((item2,index2) => (
                        <View key={"goods"+index+index2} style={{marginBottom:verticalScale(16),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                            <View style={[glSt.px16,glSt.py16]}>
                                <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb10]}>
                                    <Text></Text>
                                    <TouchableOpacity>
                                        <Text style={[glSt.cC0BCB6,glSt.text12b]}>문의하기</Text>
                                    </TouchableOpacity>
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
                                <TouchableOpacity style={[glSt.borderDBD7D0,glSt.py7,glSt.alcenter]}>
                                    <Text style={[glSt.c6F6963,glSt.text12b]}>주문취소</Text>
                                </TouchableOpacity>
                            </View>
                        </View>
                        ))}
                        
                    </View>
                    ))}
                </View>
            </ScrollView>
            <RBSheet
                    ref={refRBSheet1}
                    customStyles={{
                    container: {
                        height: 360, // 여기서 고정 높이 지정
                    },
                }}
                >
                    <View style={[glSt.bgFDFBF5,[glSt.px24,glSt.pt24,{height:500}]]}>
                        <View style={[glSt.mb32]}   >
                            <Text style={[glSt.c6F6963,glSt.text16b]}>기간설정</Text>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb18]}>
                            <TouchableOpacity onPress={() => setobdata({ob:1,obstr:'최근 1년'})} style={[glSt.px16,glSt.py7,obdata.ob == 1 ? glSt.border322A24 : glSt.borderDBD7D0]}>
                                <Text>최근 1년</Text>
                            </TouchableOpacity>
                            <TouchableOpacity onPress={() => setobdata({ob:2,obstr:'1주일'})} style={[glSt.px16,glSt.py7,obdata.ob == 2 ? glSt.border322A24 : glSt.borderDBD7D0]}>
                                <Text>1주일</Text>
                            </TouchableOpacity>
                            <TouchableOpacity onPress={() => setobdata({ob:3,obstr:'1개월'})} style={[glSt.px16,glSt.py7,obdata.ob == 3 ? glSt.border322A24 : glSt.borderDBD7D0]}>
                                <Text>1개월</Text>
                            </TouchableOpacity>
                            <TouchableOpacity onPress={() => setobdata({ob:4,obstr:'3개월'})} style={[glSt.px16,glSt.py7,obdata.ob == 4 ? glSt.border322A24 : glSt.borderDBD7D0]}>
                                <Text>3개월</Text>
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter,glSt.mb48]}>
                            <View style={[glSt.h46,glSt.borderC0BCB6,glSt.px16,glSt.jucenter,{flex:1}]}>
                                <Text style={[glSt.text14r,glSt.cC0BCB6]} >{sdate}</Text>
                            </View>
                            <View style={{backgroundColor:"#C0BCB6",height:1,width:6,marginHorizontal:horizontalScale(13)}}>
                            </View>
                            <View style={[glSt.h46,glSt.borderC0BCB6,glSt.px16,glSt.jucenter,{flex:1}]}>
                                <Text style={[glSt.text14r,glSt.cC0BCB6]} >{edate}</Text>
                            </View>
                            
                        </View>
                        <TouchableOpacity onPress={() => { refRBSheet1.current.close();  get_goods();}} style={[glSt.bg322A24,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                            <Text style={[glSt.text14b,glSt.cFFFFFF]}>조회하기</Text>
                        </TouchableOpacity>
                    </View>
                    
                </RBSheet> 
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
)(Orders);