import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";

import VersionCheck from 'react-native-version-check';
import Modal from "react-native-modal";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";


const Mymain = (props) => {
    

    return (
        <Layout havebottom={true} havetop={true} bottomsel={5} havnoback={false} havebtn1={false} havebtn2={true} toptext={"마이페이지"} navigation={props.navigation}>
            <ScrollView>
                {props.baseData.isLogin ?
                <View style={[glSt.px24]}>
                    <View style={[glSt.pt24,glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb40]}>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <View style={[glSt.mr20]}>
                                <Image source={Images.grade} style={{width:horizontalScale(42),height:horizontalScale(42)}} />
                            </View>
                            <Text style={[glSt.c322A24,glSt.text24b]}>{props.baseData.userData.name}님</Text>
                        </View>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Gradeinfo")} style={[glSt.bgF6F4EE,glSt.px14,glSt.py7]}>
                            <Text style={[glSt.c6F6963,glSt.text12b]}>등급 안내</Text>
                        </TouchableOpacity>
                    </View>
                    <View style={[glSt.mb16]}>
                        <View style={[glSt.flex]}>
                            <Text style={[glSt.c322A24,glSt.text14m]}>100,000원</Text>
                            <Text style={[glSt.cC0BCB6,glSt.text14m]}> 추가 구매 시 Bronze 달성</Text>
                        </View>
                        <Text style={[glSt.cC0BCB6,glSt.text14m]}>다음달 예상 등급 Basic</Text>
                    </View>
                    <View style={{position:"relative",height:verticalScale(3),marginBottom:verticalScale(4)}}>
                        <View style={{backgroundColor:"#6F6963",opacity:0.1,height:verticalScale(3)}}></View>
                        <View style={{width:0,backgroundColor:"#6F6963",height:verticalScale(3),position:"absolute",top:0,left:0,zIndex:1}}></View>
                    </View>
                    <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb24]}>
                        <Text style={[glSt.c322A24,glSt.text10m]}>0원</Text>
                        <Text style={[glSt.cC0BCB6,glSt.text10m]}>100,000원</Text>
                    </View>
                </View>
                :
                <View style={[glSt.px24]}>
                    <View style={[glSt.pt32]}>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Login")} style={[glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <Text style={[glSt.text18b,glSt.c322A24]}>그랑핸드 로그인・회원가입</Text>
                            <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        <View style={[glSt.mb24]}>
                            <Text style={[glSt.cC0BCB6,glSt.text12m]}>간편하게 가입하고 다양한 혜택을 만나보세요.</Text>
                        </View>
                    </View>
                </View>
                } 
                <View style={[glSt.px24]}>
                    <View style={glSt.mb16}>
                        <Image source={Images.tmpbanner} style={{width:horizontalScale(342),height:horizontalScale(100)}} />
                    </View>
                    <View style={[glSt.mb32]}>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Coupon")} style={[glSt.h46,glSt.flex,glSt.alcenter,glSt.jucenter,{borderWidth:1,borderColor:"#C0BCB6"}]}>
                            <Text style={[glSt.c322A24,glSt.text14b]}>나의 쿠폰함</Text>
                        </TouchableOpacity>
                    </View>
                    {props.baseData.isLogin ? 
                    <View style={[glSt.flex,glSt.alcenter,glSt.juaround,glSt.mb24]}>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Point")} style={[glSt.mr20,glSt.flexc,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.mb10]}>
                                <Image source={Images.icon_my1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />  
                            </View>
                            
                            <Text style={[glSt.cC0BCB6,glSt.text14m]}>포인트</Text>
                        </TouchableOpacity>
                        
                        <TouchableOpacity onPress={() => props.navigation.navigate("Attendance")} style={[glSt.mr20,glSt.flexc,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.mb10]}>
                                <Image source={Images.icon_my2} style={{width:horizontalScale(24),height:horizontalScale(24)}} />     
                            </View>
                            
                            <Text style={[glSt.cC0BCB6,glSt.text14m]}>출석체크</Text>
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Gift1")} style={[glSt.mr20,glSt.flexc,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.mb10]}>
                                <Image source={Images.icon_my5} style={{width:horizontalScale(24),height:horizontalScale(24)}} />  
                            </View>
                            
                            <Text style={[glSt.cC0BCB6,glSt.text14m]}>선물함</Text>   
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Orders")} style={[glSt.flexc,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.mb10]}>
                                <Image source={Images.icon_my4} style={{width:horizontalScale(24),height:horizontalScale(24)}} />  
                            </View>
                            
                            <Text style={[glSt.cC0BCB6,glSt.text14m]}>주문내역</Text>    
                        </TouchableOpacity>
                    </View>
                    :
                    <View style={[glSt.flex,glSt.alcenter,glSt.juaround,glSt.mb24]}>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Point")} style={[glSt.mr20,glSt.flexc,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.mb10]}>
                                <Image source={Images.icon_my1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />  
                            </View>
                            
                            <Text style={[glSt.cC0BCB6,glSt.text14m]}>포인트</Text>
                        </TouchableOpacity>
                        
                        <TouchableOpacity onPress={() => props.navigation.navigate("Attendance")} style={[glSt.mr20,glSt.flexc,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.mb10]}>
                                <Image source={Images.icon_my2} style={{width:horizontalScale(24),height:horizontalScale(24)}} />     
                            </View>
                            
                            <Text style={[glSt.cC0BCB6,glSt.text14m]}>출석체크</Text>
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Gift1")} style={[glSt.mr20,glSt.flexc,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.mb10]}>
                                <Image source={Images.icon_my5} style={{width:horizontalScale(24),height:horizontalScale(24)}} />  
                            </View>
                            
                            <Text style={[glSt.cC0BCB6,glSt.text14m]}>선물함</Text>   
                        </TouchableOpacity>
                        <TouchableOpacity  onPress={() => props.navigation.navigate("Orders")} style={[glSt.flexc,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.mb10]}>
                                <Image source={Images.icon_my4} style={{width:horizontalScale(24),height:horizontalScale(24)}} /> 
                            </View>
                            
                            <Text style={[glSt.cC0BCB6,glSt.text14m]}>주문내역</Text>    
                        </TouchableOpacity>
                    </View>
                    }
                    <View>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Recent")} style={[glSt.h64,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <Text style={[glSt.c322A24,glSt.text16m]}>최근 본 상품</Text>
                             <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Gift1")} style={[glSt.h64,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <Text style={[glSt.c322A24,glSt.text16m]}>내 선물함</Text>
                             <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Cancels")} style={[glSt.h64,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <Text style={[glSt.c322A24,glSt.text16m]}>취소/교환/반품 내역</Text>
                             <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Myinfo")} style={[glSt.h64,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <Text style={[glSt.c322A24,glSt.text16m]}>회원정보</Text>
                             <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Center")} style={[glSt.h64,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <Text style={[glSt.c322A24,glSt.text16m]}>고객센터</Text>
                             <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Config")} style={[glSt.h64,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <Text style={[glSt.c322A24,glSt.text16m]}>설정</Text>
                             <Image source={Images.icon_arrow_right} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                    </View>  
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
)(Mymain);