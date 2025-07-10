import React, { useState, useEffect, useCallback  } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';

import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import { useFocusEffect } from '@react-navigation/native';

const Request = (props) => {
    
    const [ loading, setLoading ]  = useState(true);

    const [ name , setName ] = useState('');
    const [ nameerr , setNameerr ] = useState('');

    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={"제휴문의"} navigation={props.navigation}>
                <KeyboardAwareScrollView contentContainerStyle={[glSt.px24,{ flexGrow: 1 }]}>
                    <View style={[glSt.pt24]}>
                        <View style={[glSt.mb24]}>
                            <Text style={[glSt.text12m,glSt.c322A24]}>개인 및 기업의 대량구매 문의는 대량구매 신청서를 통해 접수해주시기 바랍니다.</Text>
                        </View>
                        <View style={[glSt.mb16]}>
                            <View style={glSt.mb8}>
                                <Text style={[glSt.text14m,glSt.c322A24]}>성함*</Text>
                            </View>
                            <View style={[glSt.h46,glSt.px16,nameerr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                                <TextInput placeholder={"성함을 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} value={name} onChangeText={text => setName(text) }  />
                            </View>
                            {nameerr != '' &&
                            <View>
                                <Text style={[glSt.cFF3E24,glSt.text10m]}>{v}</Text>
                            </View>
                            }
                        </View>
                        <View style={[glSt.mb16]}>
                            <View style={glSt.mb8}>
                                <Text style={[glSt.text14m,glSt.c322A24]}>휴대폰 번호*</Text>
                            </View>
                            <View style={[glSt.h46,glSt.px16,nameerr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                                <TextInput placeholder={"연락처를 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} value={name} onChangeText={text => setName(text) }  />
                            </View>
                            {nameerr != '' &&
                            <View>
                                <Text style={[glSt.cFF3E24,glSt.text10m]}>{v}</Text>
                            </View>
                            }
                        </View>
                        <View style={[glSt.mb16]}>
                            <View style={glSt.mb8}>
                                <Text style={[glSt.text14m,glSt.c322A24]}>이메일 주소*</Text>
                            </View>
                            <View style={[glSt.h46,glSt.px16,nameerr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                                <TextInput placeholder={"이메일을 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} value={name} onChangeText={text => setName(text) }  />
                            </View>
                            {nameerr != '' &&
                            <View>
                                <Text style={[glSt.cFF3E24,glSt.text10m]}>{v}</Text>
                            </View>
                            }
                        </View>
                        <View style={[glSt.mb16]}>
                            <View style={glSt.mb8}>
                                <Text style={[glSt.text14m,glSt.c322A24]}>제목*</Text>
                            </View>
                            <View style={[glSt.h46,glSt.px16,nameerr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                                <TextInput placeholder={"제목을 입력해 주세요. (최대 40자)"} style={[glSt.text14r,glSt.c322A24]} value={name} onChangeText={text => setName(text) }  />
                            </View>
                            {nameerr != '' &&
                            <View>
                                <Text style={[glSt.cFF3E24,glSt.text10m]}>{v}</Text>
                            </View>
                            }
                        </View>
                        <View style={[glSt.mb16]}>
                            <View style={glSt.mb8}>
                                <Text style={[glSt.text14m,glSt.c322A24]}>내용*</Text>
                            </View>
                            <View style={[glSt.px16,nameerr == '' ? glSt.borderC0BCB6 : glSt.borderFF3E24]}>
                                <TextInput placeholder={"내용을 입력해주세요."} style={[glSt.text14r,glSt.c322A24,{height:verticalScale(200),textAlignVertical:"top"}]} value={name} onChangeText={text => setName(text) }  multiline />
                            </View>
                            {nameerr != '' &&
                            <View>
                                <Text style={[glSt.cFF3E24,glSt.text10m]}>{v}</Text>
                            </View>
                            }
                        </View>
                        <View style={[glSt.flex,glSt.alcenter,glSt.mb14]}>
                            <View style={[glSt.mr16]}>
                                <TouchableOpacity >
                                    <Image source={Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                                </TouchableOpacity>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter]}>
                                <View style={[glSt.mr2]}>
                                    <Text style={[glSt.c6F6963,glSt.text14b]}>개인정보 수집 및 이용 동의</Text>
                                </View>
                                <Image source={Images.icon_rarrow1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                            </View>
                        </View>
                    </View>
                </KeyboardAwareScrollView>
                <View style={[glSt.px24,glSt.pb24]}>
                    <TouchableOpacity style={[glSt.bgDBD7D0,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                        <Text style={[glSt.text14b,glSt.cFFFFFF]}>문의하기</Text>
                    </TouchableOpacity>
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
)(Request);