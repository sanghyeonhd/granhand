import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import Axios from "../../utils/Axios";
import { useFocusEffect } from '@react-navigation/native';
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";


const Guide = (props) => {
    
    const [ loading, setLoading ]  = useState(false);
    
    const [ datalist, setDatalst ] = useState([]);

    const [ da, setDa ] = useState(['','','','']);

    useFocusEffect(
        React.useCallback(() => {
            setDa(['','','','']);
        }, [])
    );
    
    useEffect(() => {
       get_datalist()
    },[]);
    
     useEffect(() => {
       console.log(da);
    },[da]);

    async function get_datalist() {
        setLoading(false);
        await Axios.get('&act=cont&han=get_guideconfig',
            (response) => {
                setDatalst(response.datas);
                console.log(response.datas);
                setTimeout(() => {
                        setLoading(true);
                }, 500); // 10000ms = 10초
            },
            (error) => console.log(error)
        );
    }

    if(loading) {
        return (
            <Layout havebottom={true} havetop={true} bottomsel={2} havnoback={false} havebtn1={true} toptext={"GUIDE"} navigation={props.navigation}>
                <View style={[glSt.h50,glSt.bgF6F4EE,glSt.flex,glSt.alcenter,glSt.jucenter,glSt.mb32]}>
                    <Text style={[glSt.text10m,glSt.c6F6963]}>✨ 원하시는 향을 추천해 드립니다. 아래 항목을 모두 선택해 주세요.</Text>
                </View>
                <View style={[glSt.pl24,{marginBottom:verticalScale(60)}]}>
                    {datalist.map((item,index) => (
                    <View key={"list"+index} style={[glSt.mb30,glSt.flex,glSt.alstart]}>
                        <View style={[glSt.mr24]}>
                            <View style={[glSt.mb23]}>
                                {da[index] == '' ?
                                <Image source={Images.icon_ch_off} style={{width:horizontalScale(24),height:horizontalScale(24)}}></Image>
                                :
                                <Image source={Images.icon_ch_on} style={{width:horizontalScale(24),height:horizontalScale(24)}}></Image>
                                }
                            </View>
                            {index < 3 &&
                            <>
                                {da[index] == '' ?
                                <Image source={Images.icon_chs_off} style={{width:horizontalScale(24),height:horizontalScale(24)}}></Image>
                                :
                                <Image source={Images.icon_chs_on} style={{width:horizontalScale(24),height:horizontalScale(24)}}></Image>
                                }
                            </>
                            
                            }
                        </View>
                        <View style={{borderBottomColor:"#E9E6E1",borderBottomWidth:1,flex:1}}>
                            <View style={[glSt.mb8]}>
                                <Text style={[glSt.text14b,glSt.c6F6963]}>{item.subject}</Text>
                            </View>
                            {(index == 0 || da[index - 1] != '') &&
                            <ScrollView horizontal showsHorizontalScrollIndicator={false} style={[glSt.mb8,glSt.flex]}>
                                {item.itemlist.map((item2,index2) => (
                                <TouchableOpacity onPress={() => setDa(prev => {
                                    const newArr = [...prev];
                                    newArr[index] = item2;
                                    return newArr;
                                    })} key={"items"+index2} style={[glSt.mr8,glSt.px8,glSt.py4, da[index] === item2 && glSt.bg322A24]}>
                                    <Text style={[da[index] == item2 ? glSt.cFDFBF5 : glSt.c231815 , glSt.text12r]}>{item2}</Text>
                                </TouchableOpacity>
                                ))}
                            </ScrollView>
                            }
                        </View>
                        
                    </View>
                    ))}
                </View>
                <View style={[glSt.px24]}>
                    {da.every(item => item !== '') &&
                    <TouchableOpacity onPress={() => props.navigation.navigate("Guideresult")} style={[glSt.borderC0BCB6,glSt.h46,glSt.alcenter,glSt.jucenter]}>
                        <Text style={[glSt.c322A24,glSt.text14b]}>결과보기</Text>
                    </TouchableOpacity>
                    }
                </View>
                
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
)(Guide);