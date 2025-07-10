import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';
import Modal, { ReactNativeModal } from "react-native-modal";

import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import AlertModal from "../../components/AlertModal";


const Joinstep1 = (props) => {
    
    const [inputs, setInputs] = useState({
        allcheck: false,
		check1: false,
        check2: false,
        check3: false,
        check4: false,
        check5: false
    });

    const { allcheck, check1, check2, check3, check4, check5 } = inputs;

    const [ isModalVisible , setIsModalVisible ] = useState(false);
    const [ modalmode , setModalmode ]  = useState({types:'',str:'',check:false,t:0});
    const [ alerts, setAlerts ] = useState({show:false,str:""});

    useEffect(() => {
        
    }, []);

    function checkall()	{
		if(allcheck)	{
			setInputs({
				allcheck:false,
				check1: false,
                check2: false,
                check3: false,
                check4: false,
                check5: false,
			});
		}
		else{
			setInputs({
				allcheck:true,
				check1: true,
                check2: true,
                check3: true,
                check4: true,
                check5: true,
			});
		}
	}

    function gotonext() {

        if(!check1) {
            setAlerts({show:true,str:"만14세 이상 가입가능합니다."})
            return;
        }
        if(!check2) {
            setAlerts({show:true,str:"서비스이용약관에 동의해주세요."})
            return;
            
        }
        if(!check3) {
            setAlerts({show:true,str:"개인정보 수집 및 이용 동의해주세요."})
            return;
        }

        props.navigation.navigate("Joinstep2")
    }

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} navigation={props.navigation}>
            <View style={{position:"relative",height:verticalScale(4)}}>
                <View style={{backgroundColor:"#6F6963",opacity:0.1,height:verticalScale(4)}}></View>
                <View style={{width:"25%",backgroundColor:"#6F6963",height:verticalScale(4),position:"absolute",top:0,left:0,zIndex:1}}></View>
            </View>
            <KeyboardAwareScrollView contentContainerStyle={[glSt.px24,{ flexGrow: 1 }]}>
                <View style={[glSt.pt50]}>
                    <View style={[glSt.mb32]}>
                        <Text style={[glSt.text16m,glSt.c322A24]}>그랑핸드 서비스 이용 약관에 동의해 주세요.</Text>
                    </View>
                    <View style={[glSt.mb22,glSt.flex,glSt.alcenter]}>
                        <View style={[glSt.mr16]}>
                            <TouchableOpacity onPress={() => checkall()}>
                                <Image source={allcheck ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <Text style={[glSt.text14b,glSt.c6F6963]}>모두 동의 (선택 정보 포함)</Text>
                        </View>
                    </View>
                    <View style={[glSt.mb24,{borderBottomWidth: 1,borderStyle: 'dashed',borderColor: '#DBD7D0',width: '100%',}]}></View>
                    <View style={[glSt.flex,glSt.alcenter,glSt.mb14]}>
                        <View style={[glSt.mr16]}>
                            <TouchableOpacity onPress={() => setInputs({...inputs,check1:!check1})}>
                                <Image source={check1 ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <View style={[glSt.mr8]}>
                                <Text style={[glSt.c6F6963,glSt.text12r]}>(필수)</Text>
                            </View>
                            <View style={[glSt.mr2]}>
                                <Text style={[glSt.c6F6963,glSt.text14b]}>만 14세 이상입니다</Text>
                            </View>
                        </View>
                    </View>
                    <View style={[glSt.flex,glSt.alcenter,glSt.mb14]}>
                        <View style={[glSt.mr16]}>
                            <TouchableOpacity onPress={() => setInputs({...inputs,check2:!check2})}>
                                <Image source={check2 ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <View style={[glSt.mr8]}>
                                <Text style={[glSt.c6F6963,glSt.text12r]}>(필수)</Text>
                            </View>
                            <TouchableOpacity onPress={() => { setModalmode({types:'필수',str:'서비스 이용 약관 동의',check:check2,t:2}); setIsModalVisible(true) } } style={[glSt.mr2]}>
                                <Text style={[glSt.c6F6963,glSt.text14b]}>서비스 이용 약관 동의</Text>
                            </TouchableOpacity>
                            <Image source={Images.icon_rarrow1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                    </View>
                    <View style={[glSt.flex,glSt.alcenter,glSt.mb14]}>
                        <View style={[glSt.mr16]}>
                            <TouchableOpacity onPress={() => setInputs({...inputs,check3:!check3})}>
                                <Image source={check3 ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <View style={[glSt.mr8]}>
                                <Text style={[glSt.c6F6963,glSt.text12r]}>(필수)</Text>
                            </View>
                            <View style={[glSt.mr2]}>
                                <Text style={[glSt.c6F6963,glSt.text14b]}>개인정보 수집 및 이용 동의</Text>
                            </View>
                            <Image source={Images.icon_rarrow1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                    </View>
                    <View style={[glSt.flex,glSt.alcenter,glSt.mb14]}>
                        <View style={[glSt.mr16]}>
                            <TouchableOpacity onPress={() => setInputs({...inputs,check4:!check4})}>
                                <Image source={check4 ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <View style={[glSt.mr8]}>
                                <Text style={[glSt.c6F6963,glSt.text12r]}>(선택)</Text>
                            </View>
                            <View style={[glSt.mr2]}>
                                <Text style={[glSt.c6F6963,glSt.text14b]}>마케팅 목적의 개인정보 수집 및 이용 동의</Text>
                            </View>
                            <Image source={Images.icon_rarrow1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                    </View>
                    <View style={[glSt.flex,glSt.alcenter,glSt.mb14]}>
                        <View style={[glSt.mr16]}>
                            <TouchableOpacity onPress={() => setInputs({...inputs,check5:!check5})}>
                                <Image source={check5 ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <View style={[glSt.mr8]}>
                                <Text style={[glSt.c6F6963,glSt.text12r]}>(선택)</Text>
                            </View>
                            <View style={[glSt.mr2]}>
                                <Text style={[glSt.c6F6963,glSt.text14b]}>광고성 정보 수신 동의</Text>
                            </View>
                            <Image source={Images.icon_rarrow1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                    </View>
                </View>
            </KeyboardAwareScrollView>
            <View style={[glSt.px24,glSt.pb24]}>
                <TouchableOpacity onPress={() => gotonext()} style={[glSt.h46,(check1 && check2 && check3) ? glSt.bg322A24 : glSt.bgDBD7D0,glSt.mb24,glSt.alcenter,glSt.jucenter]}>
                    <Text style={[glSt.text14b,glSt.cFFFFFF]}>동의하고 가입하기</Text>
                </TouchableOpacity>
            </View>
            <ReactNativeModal isVisible={isModalVisible} style={{margin: 0,justifyContent:"center",alignItems:"center"}}  onBackdropPress={async () => await setIsModalVisible(false)} hideModalContentWhileAnimating={true} backdropTransitionOutTiming={0}>
                <View style={[glSt.bgFDFBF5,{flex:1,width:"100%"}]}>
                    <View style={[glSt.h58,glSt.px24,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <TouchableOpacity onPress={() => setIsModalVisible(false)} style={[glSt.mr24]}>
                                <Image source={Images.icon_back} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                            </TouchableOpacity>
                        </View>
                    </View>
                    <View style={[glSt.px24]}>
                        <View style={[glSt.flex,glSt.alcenter,glSt.mb14,glSt.pt32]}>
                            <View style={[glSt.mr16]}>
                                <TouchableOpacity>
                                    <Image source={modalmode.check ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                                </TouchableOpacity>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter]}>
                                <View style={[glSt.mr8]}>
                                    <Text style={[glSt.c6F6963,glSt.text12r]}>({modalmode.types})</Text>
                                </View>
                                <TouchableOpacity onPress={() => { setModalmode('1'); setIsModalVisible(true) } } style={[glSt.mr2]}>
                                    <Text style={[glSt.c6F6963,glSt.text14b]}>{modalmode.str}</Text>
                                </TouchableOpacity>
                            </View>
                        </View>
                    </View>
                    <View style={[glSt.px24,{flex:1}]}>
                        <View style={{backgroundColor:"#FFFFFF",borderWidth:1,borderColor:"#E9E6E0",flex:1}}>
                            <ScrollView>

                            </ScrollView>
                        </View>                        
                    </View>
                    <View style={[glSt.px24,glSt.pt24]}>
                        <TouchableOpacity onPress={() => setIsModalVisible(false)} style={[glSt.h46,modalmode.check ? glSt.bg322A24 :glSt.bgDBD7D0 ,glSt.mb24,glSt.alcenter,glSt.jucenter]}>
                            <Text style={[glSt.text14b,glSt.cFFFFFF]}>동의</Text>
                        </TouchableOpacity>
                    </View>
                </View>
            </ReactNativeModal>
            <AlertModal
                visible={alerts.show}
                oneButton={true}
                title="알림"
                message={alerts.str}
                confirmText="로그인"
                cancelText="확인"
                onConfirm={() => {
                    console.log('이동 버튼 눌림');
                }}
                onCancel={() => {
                    console.log('취소 버튼 눌림');
                }}
                onClose={() => setAlerts({show:false,str:""})}
            />
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
)(Joinstep1);