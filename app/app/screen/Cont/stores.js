import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { AutoSizeRemoteImage, Image, Text } from "../../components/index";
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';

import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";


const Stores = (props) => {
    
    const [ loading, setLoading ] = useState(false);
    const [ brandidx, setBrandidx ] = useState('');
    const [ storeidx, setStoreidx ] = useState('');
    const [ datalist, setDatalist ] = useState();

    useEffect(() => {
        get_store()
    }, [brandidx,storeidx]);



    async function get_store() {

        await Axios.get('&act=cont&han=get_store&brandidx='+brandidx+"&storeidx="+storeidx,
            (response) => {
                setDatalist(response.datas);
                setBrandidx(response.datas.brandidx);
                setStoreidx(response.datas.storeidx);
                setLoading(true);
                console.log(response.datas);
            },
            (error) => console.log(error)
        );
    }

    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={"STORE"} navigation={props.navigation}>
                <View style={[glSt.h54,glSt.px24,glSt.flex,glSt.alcenter]}>
                    {datalist.brlist.map((item,index) => (
                    <TouchableOpacity key={"br"+index} onPress={() => {setStoreidx(0); setBrandidx(item.idx); }}>
                        <Text style={[glSt.mr16,glSt.text14b,item.issel == "Y" ? glSt.c322A24 : glSt.cC0BCB6]}>{item.brandname}</Text>
                    </TouchableOpacity>     
                    ))}
                </View>
                <View style={[glSt.h54,glSt.px24,glSt.flex,glSt.alcenter,glSt.mb8]}>
                    {datalist.storelist.map((item,index) => (
                    <TouchableOpacity key={"st"+index} onPress={() => setStoreidx(item.idx)}>
                        <Text style={[glSt.mr16,glSt.text12b,item.issel == "Y" ? glSt.c322A24 : glSt.cC0BCB6]}>{item.name}</Text>
                    </TouchableOpacity>     
                    ))}
                </View>
                <ScrollView>
                    {datalist.store &&
                    <View style={[glSt.px24]}     >
                        <View style={[glSt.flex,glSt.alcenter,glSt.mb14]}>
                            <View style={[glSt.mr8]}>
                                <Text style={[glSt.text12m,glSt.c322A24]}>{datalist.store.fullname}</Text>
                            </View>  
                            <View>
                                <Text style={[glSt.text12r,glSt.cC0BCB6]}>{datalist.store.addr}</Text>
                            </View>  
                        </View>
                        {datalist.store.imgs.map((item,index) => (
                        <View key={"img"+index} style={[glSt.mb16]}> 
                            <AutoSizeRemoteImage uri={item.imgurl} basewidth={Dimensions.get("screen").width - horizontalScale(48)} />
                        </View> 
                        ))}
                    </View>
                    }
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
)(Stores);