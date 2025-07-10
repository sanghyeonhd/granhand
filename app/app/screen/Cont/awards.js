import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, Share, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { AutoSizeRemoteImage, Image, Text } from "../../components/index";
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';


import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";


const Awards = (props) => {
    
    const [ viewmode, setViewmode ] = useState(1);
    const [ sviewmode, setSviewmode ] = useState(1);

    const onShare = async () => {
                try {
                    const result = await Share.share({
                        title: "그랑핸즈 어워드",
                        message: '',
                        url: 'http://www.granhand.kro.kr/cont/?act=awards' // iOS에서 message 대신 url을 사용할 수 있음
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
    

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} toptext={"AWARDS"} onSharePress={onShare} havebtn4={true} navigation={props.navigation}>
            <View style={[glSt.h54,glSt.px24,glSt.flex,glSt.alcenter]}>
                <TouchableOpacity onPress={() => setViewmode(1)} style={[glSt.mr16]}>
                        <Text style={[glSt.mr16,glSt.text14b,viewmode === 1 ? glSt.c322A24 : glSt.cC0BCB6]}>필름사진상</Text>
                </TouchableOpacity> 
            </View>
            <View style={[glSt.h54,glSt.px24,glSt.flex,glSt.alcenter]}>
                <TouchableOpacity onPress={() => setSviewmode(1)} style={[glSt.mr16]}>
                    <Text style={[glSt.mr16,glSt.text12b,sviewmode === 1 ? glSt.c322A24 : glSt.cC0BCB6]}>행사안내</Text>
                </TouchableOpacity> 
                <TouchableOpacity onPress={() => setSviewmode(2)} style={[glSt.mr16]}>
                    <Text style={[glSt.mr16,glSt.text12b,sviewmode === 2 ? glSt.c322A24 : glSt.cC0BCB6]}>참가접수</Text>
                </TouchableOpacity> 
                <TouchableOpacity onPress={() => setSviewmode(2)} style={[glSt.mr16]}>
                    <Text style={[glSt.mr16,glSt.text12b,sviewmode === 3 ? glSt.c322A24 : glSt.cC0BCB6]}>당선작</Text>
                </TouchableOpacity> 
            </View>
            <ScrollView>
                <View style={[glSt.px24]}>
                    {sviewmode == 1 && 
                    <>
                    <View style={[glSt.mb24]}>
                        <AutoSizeRemoteImage uri={"http://www.granhand.kro.kr/fsg/board/Frame480957946.png"} basewidth={Dimensions.get("screen").width - horizontalScale(48)} />
                    </View>
                    <View style={glSt.mb10}>
                        <Text style={[glSt.c322A24,glSt.text14r]}>그랑핸드 필름사진상은 그랑핸드가 유지하는 아날로그 감성과 향에 대한 심상을 사진으로 표현하여 아마추어리즘 작가를 발굴하고 소개합니다. 수상자들은 그랑핸드와 함께 다양한 협업을 진행하여 전시에 참여할 기회가 제공됩니다.</Text>
                    </View>
                    <View>
                        <Text style={[glSt.c322A24,glSt.text14b]}>수상</Text>
                    </View>
                    <View style={glSt.mb10}>
                        <Text style={[glSt.c322A24,glSt.text14r]}>필름사진 아마추어 및 애호가를 대상으로 매년 1회 실시합니다. 컬러 또는 흑백 네거티브 필름으로 촬영한 작품만 접수하실 수 있으며 디지털 사진 작품은 허용되지 않습니다.</Text>
                    </View>
                    </>
                    }
                     {sviewmode == 2 && 
                    <>
                    <View style={[{flex:1},glSt.alcenter,glSt.jucenter,glSt.pt54]}>
                        <Text style={[glSt.c322A24,glSt.text14r]}>현재 접수기간이 아닙니다.</Text>
                    </View>
                    </>
                    }
                </View>
            </ScrollView>                      
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
)(Awards);