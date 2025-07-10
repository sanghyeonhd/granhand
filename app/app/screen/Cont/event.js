import React, { useState, useEffect, useCallback } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  View, TouchableOpacity, Dimensions, ScrollView, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text, AutoSizeRemoteImage } from "../../components/index";
import { useFocusEffect } from '@react-navigation/native';
import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";


const Event = (props) => {
    
    const [ loading, setLoading ]  = useState(false);
    
    const [ datalist, setDatalst ] = useState([]);
    
    useEffect(() => {
    
       get_datalist()
    },[]);
    

    async function get_datalist() {
        setLoading(false);
        await Axios.get('&act=cont&han=get_event',
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
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={"EVENT"} navigation={props.navigation}>
                <ScrollView>
                    {datalist.map((item,index) =>(
                    <TouchableOpacity key={"list"+index} style={[glSt.px24,glSt.mt16]} onPress={() => props.navigation.navigate("Eventv",{idx:item.idx})}>
                        <View style={[glSt.mb8]}>
                            <AutoSizeRemoteImage uri={item.imgurl} basewidth={Dimensions.get("window").width - horizontalScale(48)}></AutoSizeRemoteImage>
                        </View>
                        <View style={[glSt.mb4]}>
                            <Text style={[glSt.c322A24,glSt.text14m]}>{item.subject}</Text>
                        </View>
                        <Text style={[glSt.cC0BCB6,glSt.text12r]}>{item.wdate.substring(0, 10)}</Text>
                    </TouchableOpacity>
                    ))}
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
)(Event);