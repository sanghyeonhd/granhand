import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { AutoSizeRemoteImage, Image, Text } from "../../components/index";

import VersionCheck from 'react-native-version-check';
import Modal from "react-native-modal";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import Axios from "../../utils/Axios";

const itemwidth = (Dimensions.get("window").width - horizontalScale(64)) / 2


const Wish = (props) => {
    
    useEffect(() => {
        if(!props.baseData.isLogin) {
            props.navigation.replace('Login', { redirectTo: 'Mymain' });
        }
    }, [props.baseData.isLogin]);

    const [ loading, setLoading ]  = useState(false);
    const [ datalist, setDatalst ] = useState([]);
    
    useEffect(() => {
    
       get_datalist()
    },[]);
    

    async function get_datalist() {
        setLoading(false);
        await Axios.get('&act=goods&han=get_wish&mem_idx='+props.baseData.userData.idx,
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

    async function set_wish(idx) {

        if(props.baseData.isLogin){
            await Axios.get('&act=goods&han=set_wish&goods_idx='+idx+"&mem_idx="+props.baseData.userData.idx,
            (response) => {
                if(response.res == 'ok1')   {
                   setDatalst(prev =>
                        prev.map(item =>
                        item.idx === idx ? { ...item, havewish: 'Y' } : item
                    ));
                }   else    {
                  setDatalst(prev =>
                    prev.filter(item => item.idx !== idx)
                    );
                }
            },
            (error) => console.log(error)
            );
        } 
    }

    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"관심상품"} navigation={props.navigation}>
                <View style={[glSt.px24]}>
                    {datalist.length == 0 ?
                    <View style={[glSt.alcenter,glSt.jucenter,glSt.pt54]}>
                        <Text style={[glSt.cC0BCB6,glSt.text14m]}>관심상품이 없어요.</Text>
                    </View>
                    :
                    <ScrollView>
                        <View style={[glSt.flex,glSt.alcenter]}>
                        {datalist.map((item,index) => (
                        <TouchableOpacity onPress={() => props.navigation.navigate("Shopview",{idx:item.idx})} key={"list"+index} style={[glSt.mb16,index % 2 == 0 ? glSt.mr8 : glSt.ml8]}>
                            <View style={[glSt.mb8,{position:"relative"}]}>
                                
                                <AutoSizeRemoteImage uri={item.imgurl} basewidth={itemwidth} />    
                                <TouchableOpacity onPress={() => set_wish(item.idx)} style={{position:"absolute",top:horizontalScale(16),right:horizontalScale(16 )}}>
                                     <Image source={item.havewish == 'Y' ? Images.icon_heartg_on : Images.icon_heartg_off} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                                </TouchableOpacity>
                            </View>
                            <Text style={[glSt.c000000,glSt.text14b]}>{item.gname}</Text>
                            <Text style={[glSt.cC0BCB6,glSt.text12r]}>{item.gname_pre}</Text>
                            <Text style={[glSt.c322A24,glSt.text12r]}>{item.account}</Text>
                        </TouchableOpacity> 
                        ))}
                        </View>
                    </ScrollView>
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
)(Wish);