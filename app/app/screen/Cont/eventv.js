import React, { useState, useEffect, useRef } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  View, TouchableOpacity, Dimensions, ScrollView, Share, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text, AutoSizeRemoteImage } from "../../components/index";
import { useFocusEffect } from '@react-navigation/native';
import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import RenderHTML from 'react-native-render-html';

const Eventv = (props) => {
    


    const [ loading, setLoading ]  = useState(false);
    
    const [ data, setData ] = useState('');
    const [ idx, setIdx ] = useState(0);

    const scrollViewRef = useRef();
    const [contentHeight, setContentHeight] = useState(0);
    const [htmlContent , setHtmlContent ] = useState('');
    
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
            get_event()
        }
    },[idx]);

    async function get_event() {
        setLoading(false);
        await Axios.get('&act=cont&han=get_eventv&idx='+idx,
            (response) => {
                setData(response.datas);
                console.log(response.datas);
                setHtmlContent(response.datas.memo);
                setTimeout(() => {
                        setLoading(true);
                }, 500); // 10000ms = 10초
            },
            (error) => console.log(error)
        );
    }

    const onShare = async () => {
            try {
                const result = await Share.share({
                    title: data.subject,
                    message: '',
                    url: 'http://www.granhand.kro.kr/cont/?act=eventv&idx='+data.idx // iOS에서 message 대신 url을 사용할 수 있음
                });
    
                if (result.action === Share.sharedAction) {
                    if (result.activityType) {
                        console.log("특정 앱으로 공유됨:", result.activityType);
                } else {
                    console.log("공유 완료");
                }
                } else if (result.action === Share.dismissedAction) {
                    console.log("공유 취소됨");
                }
            } catch (error) {
                console.error("공유 에러:", error.message);
            }
        };

    
    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} haveshare={true} havebtn4={true} toptext={"EVENT"} onSharePress={onShare} navigation={props.navigation}>
                <ScrollView>
                    <View style={[glSt.pl24]}    >
                        <View style={[glSt.mb32]}>
                            <AutoSizeRemoteImage uri={data.imgurl} basewidth={Dimensions.get("window").width - horizontalScale(24)}></AutoSizeRemoteImage>
                        </View>
                    </View>
                    <View style={[glSt.px24]}>
                        <View style={[glSt.mb4]}>
                            <Text style={[glSt.text16m,glSt.c322A24]}>{data.subject}</Text>
                        </View>
                        <View style={[glSt.mb32]}>
                            <Text style={[glSt.text12r,glSt.cC0BCB6]}>{data.wdate.substring(0, 10)}</Text>
                        </View>
                        <RenderHTML
                            contentWidth={Dimensions.get('window').width - horizontalScale(48)}
                            source={{ html: htmlContent }}
                        />
                        <View style={{height:60}}></View>
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
)(Eventv);