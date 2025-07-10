import React, { useState, useEffect, useRef } from "react";
import {SafeAreaView, SafeAreaProvider} from 'react-native-safe-area-context';
import { useSelector } from 'react-redux';
import { View, TouchableOpacity, StyleSheet } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config";
import { Text, Image } from "../../components/index";

import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import AlertModal from "../AlertModal";
import Modal from 'react-native-modal';

import {
  Camera,
  useCameraDevices,
  useCodeScanner,
  getCameraDevice,
} from "react-native-vision-camera";

export default Layout = (props) => {

    const isLogin = useSelector(state => state.auth.isLogin);
    

    const [ modalVisible, setModalVisible] = useState(false);
    const [ isOneButton, setIsOneButton] = useState(false);
    const [ scanview, setScanview] = useState(false);
    const [ infoview, setInfoview] = useState(false);
    const [ viewmode, setViewmode ] = useState(1);

    const devices = useCameraDevices();
    const device = getCameraDevice(devices, "back");  
    const [caview, setCaview] = useState(false);
    const [isScanning, setIsScanning] = useState(true);
        
        
    const codeScanner = useCodeScanner({
        codeTypes: ['ean-13'],
        onCodeScanned: (codes) => {
                for (const code of codes) {
                    setIsScanning(false)
                    console.log(`Code Value: ${code.value}`);
                    setCaview(false);  
                }
        },
    });
    
    return (
        <SafeAreaProvider>
            <SafeAreaView style={[glSt.bgFDFBF5,{flex:1}]}>
                {props.havetop &&
                <View style={[glSt.h58,glSt.px24,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                    <View style={[glSt.flex,glSt.alcenter]}>
                        {props.havnoback &&
                        <TouchableOpacity onPress={() => props.navigation.goBack()} style={[glSt.mr24]}>
                            <Image source={Images.icon_back} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        }
                        <Text style={[glSt.text18b,glSt.c322A24]}>{props.toptext}</Text>
                    </View>
                    {props.havebtn1 &&
                    <View style={[glSt.flex,glSt.alcenter]}>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Search")} style={[glSt.mr24]}>
                            <Image source={Images.icon_search} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Cart")} style={[]}>
                            <Image source={Images.icon_cart} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                    </View>
                    }
                    {props.havebtn2 &&
                    <View style={[glSt.flex,glSt.alcenter]}>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Alarm")} style={[glSt.mr24]}>
                            <Image source={Images.icon_alarm} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Cart")} style={[]}>
                            <Image source={Images.icon_cart} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                    </View>
                    }
                    {props.havebtn3 &&
                    <View style={[glSt.flex,glSt.alcenter]}>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Alarmconfig")} style={[]}>
                            <Image source={Images.icon_config} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                    </View>
                    }
                    {props.havebtn4 &&
                    <View style={[glSt.flex,glSt.alcenter]}>
                        <TouchableOpacity  onPress={props.onSharePress} style={[]}>
                            <Image source={Images.icon_share} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                    </View>
                    }
                </View>
                }
                <View style={[glSt.bgFDFBF5,{flex:1}]}>
                    {props.children}         
                </View>
                {props.havebottom &&
                <View style={[glSt.h60,glSt.alcenter,glSt.jubetween,glSt.flex]}>
                    <TouchableOpacity onPress={() => props.navigation.navigate("Home")} style={[glSt.alcenter,{flex:1},props.bottomsel == 1 ? {opacity: 1}:{opacity: 0.2}]}>
                        <View style={[glSt.mb8]} >
                            <Image source={Images.icon_1_off} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                        </View>
                        <Text style={[glSt.text11b,glSt.c322A24]}>홈</Text>                
                    </TouchableOpacity>
                    <TouchableOpacity onPress={() => props.navigation.navigate("Guide")} style={[glSt.alcenter,{flex:1},props.bottomsel == 2 ? {opacity: 1}:{opacity: 0.2}]}>
                        <View style={[glSt.mb8]} >
                            <Image source={Images.icon_2_off} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                        </View>
                        <Text style={[glSt.text11b,glSt.c322A24]}>향 가이드</Text>
                    </TouchableOpacity>
                    {isLogin ?
                    <TouchableOpacity onPress={() => setScanview(true)} style={[glSt.alcenter,{flex:1},{opacity: 0.2}]}>
                        <View style={[glSt.mb8]} >
                            <Image source={Images.icon_3_off} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                        </View>
                        <Text style={[glSt.text11b,glSt.c322A24]}>스캔</Text>
                    </TouchableOpacity>
                    :
                    <TouchableOpacity onPress={() => { setViewmode(1); setModalVisible(true)}} style={[glSt.alcenter,{flex:1},{opacity: 0.2}]}>
                        <View style={[glSt.mb8]} >
                            <Image source={Images.icon_3_off} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                        </View>
                        <Text style={[glSt.text11b,glSt.c322A24]}>스캔</Text>
                    </TouchableOpacity>
                    }
                    
                    <TouchableOpacity onPress={() => props.navigation.navigate("Wish")} style={[glSt.alcenter,{flex:1},props.bottomsel == 4 ? {opacity: 1}:{opacity: 0.2}]}>
                        <View style={[glSt.mb8]} >
                            <Image source={Images.icon_4_off} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                        </View>
                        <Text style={[glSt.text11b,glSt.c322A24]}>관심상품</Text>
                    </TouchableOpacity>
                    <TouchableOpacity onPress={() => props.navigation.navigate("Mymain")} style={[glSt.alcenter,{flex:1},props.bottomsel == 5 ? {opacity: 1}:{opacity: 0.2}]}>
                        <View style={[glSt.mb8]} >
                            <Image source={Images.icon_5_off} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                        </View>
                        <Text style={[glSt.text11b,glSt.c322A24]}>My</Text>
                    </TouchableOpacity>
                </View>
                }
                <AlertModal
                    visible={modalVisible}
                    oneButton={isOneButton}
                    title="이용안내"
                    message="로그인후 이용가능 합니다."
                    confirmText="로그인"
                    cancelText="닫기"
                    onConfirm={() => {
                        console.log('이동 버튼 눌림');
                        props.navigation.navigate('Login'); // 원하는 화면으로 이동
                    }}
                    onCancel={() => {
                        console.log('취소 버튼 눌림');
                    }}
                    onClose={() => setModalVisible(false)}
                />
                <Modal 
                    isVisible={scanview}
                >
                    {viewmode == 1 &&
                    <View style={[glSt.bgFDFBF5,glSt.pt24,glSt.pb37,{position:"relative"}]}>
                        <TouchableOpacity onPress={() => setScanview(false)} style={{position:"absolute",top:-30,right:0}}>
                            <Image source={Images.icon_close_white} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                        </TouchableOpacity>
                        <View style={[glSt.alcenter,glSt.mb3]}>
                            <Text style={[glSt.cFF6B62,glSt.text12m]}>10:48</Text>
                        </View>
                        <View style={[glSt.alcenter,glSt.mb32]}>
                            <Text style={[glSt.c000000,glSt.text16b]}>나의 QR 코드</Text>
                        </View>
                        <View style={[glSt.alcenter,glSt.mb44]}>
                            <Image source={Images.qr} style={{width:horizontalScale(208),height:horizontalScale(208)}}  />    
                        </View>
                        <View style={[glSt.flex,glSt.alcenter,glSt.jucenter,glSt.mb38,glSt.px24]}>
                            <TouchableOpacity onPress={() => setViewmode(2)} style={[{flex:1},glSt.alcenter]}>
                                <View style={[glSt.mb8]}>
                                    <Image source={Images.icon_s1} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />    
                                </View>
                                <Text style={[glSt.c322A24,glSt.text14m]}>콤포타블 커피</Text>
                                <Text style={[glSt.c322A24,glSt.text14m]}>스탬프</Text>
                            </TouchableOpacity>
                            <View style={{borderLeftWidth: 1,borderColor: '#C0BCB6',borderStyle: 'dashed',height: verticalScale(60),marginHorizontal: 20,}}/>
                            <TouchableOpacity onPress={() => setViewmode(3)} style={[{flex:1},glSt.alcenter]}>
                                <View style={[glSt.mb8]}>
                                    <Image source={Images.icon_s2} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />    
                                </View>
                                <Text style={[glSt.c322A24,glSt.text14m]}>그랑핸드</Text>
                                <Text style={[glSt.c322A24,glSt.text14m]}>패스포트</Text>
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.alcenter]}>
                            <TouchableOpacity onPress={() => setInfoview(true)}>
                                <Text style={[glSt.cC0BCB6,glSt.text12b]}>스탬프 및 QR 이용안내</Text>
                            </TouchableOpacity>
                        </View>
                    </View>
                    }
                    {viewmode == 2 &&
                    <View style={[glSt.bgFDFBF5,{position:"relative"}]}>
                        <TouchableOpacity onPress={() => setViewmode(1)} style={{position:"absolute",top:-30,right:0}}>
                            <Image source={Images.icon_close_white} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                        </TouchableOpacity>
                        <View style={[glSt.px16,glSt.pb24,glSt.pt48]}>
                            <View style={[glSt.alcenter,glSt.pb24]}>
                                <Text style={[glSt.c000000,glSt.text16b]}>콤포타블 스탬프</Text>
                            </View>
                            <View style={[glSt.alcenter,glSt.mb40]}>
                                <Text style={[glSt.c6F6963,glSt.text14m]}>콤포타블 커피에서 스탬프를 모아보세요!</Text>
                                <Text style={[glSt.c6F6963,glSt.text14m]}> 5/10/15/20개를 모으면 쿠폰으로 사용할 수 있어요.</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween]}>
                                <View style={[glSt.flex,glSt.alcenter,glSt.jubetween]}>
                                    <TouchableOpacity onPress={() => setViewmode(1)}>
                                        <Image source={Images.icon_back} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                                    </TouchableOpacity>
                                    <Text style={[glSt.c5E5955,glSt.text12m]}>뒤로가기</Text>
                                </View>
                                <View>
                                    <Text style={[glSt.c5E5955,glSt.text12m]}>0 / 8</Text>
                                </View>
                            </View>
                            <View style={[glSt.bgF6F4EE,glSt.mb16,glSt.jubetween,glSt.px14,glSt.py20,glSt.flex,glSt.alcenter,{flexWrap:"wrap"}]}>
                                {Array.from({length: 20}).map((_, index) => (
                                    <View key={"s1"+index} style={[{marginBottom:verticalScale(26),borderRadius:50,backgroundColor:"#FFFFFF",borderWidth:1,borderColor:"#E9E6E0",width:horizontalScale(50),height:horizontalScale(50)}]}>

                                    </View>
                                ))}
                            </View>
                            <View>
                                <TouchableOpacity style={{height:verticalScale(34),backgroundColor:"#F6F4EE",alignItems:"center",justifyContent:"center"}}>
                                    <Text style={[glSt.text12b,glSt.cDBD7D0]}>쿠폰저장</Text>
                                </TouchableOpacity>
                            </View>
                        </View>
                        
                    </View>
                    }
                    {viewmode == 3 &&
                    <View style={[glSt.bgFDFBF5,glSt.pt24,glSt.pb37,{position:"relative"}]}>
                        <TouchableOpacity onPress={() => setViewmode(1)} style={{position:"absolute",top:-30,right:0}}>
                            <Image source={Images.icon_close_white} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                        </TouchableOpacity>
                        <View style={[glSt.px16,glSt.pb24,glSt.pt48]}>
                            <View style={[glSt.alcenter,glSt.mb12]}>
                                <Text style={[glSt.c000000,glSt.text16b]}>그랑핸드 패스포트</Text>
                            </View>
                            <View style={[glSt.alcenter,glSt.mb36]}>
                                <Text style={[glSt.c6F6963,glSt.text14m]}>그랑핸드 전 매장에서 스탬프를 모아보세요!</Text>
                                <Text style={[glSt.c6F6963,glSt.text14m]}>전 지점 스탬프를 모으시면</Text>
                                <Text style={[glSt.c6F6963,glSt.text14m]}>패스포트 챌린지 달성 쿠폰을 선물해 드려요.</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb10]}>
                                <View style={[glSt.flex,glSt.alcenter,glSt.jubetween]}>
                                    <TouchableOpacity onPress={() => setViewmode(1)}>
                                        <Image source={Images.icon_back} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                                    </TouchableOpacity>
                                    <Text style={[glSt.c5E5955,glSt.text12m]}>뒤로가기</Text>
                                </View>
                                <View>
                                    <Text style={[glSt.c5E5955,glSt.text12m]}>0 / 8</Text>
                                </View>
                            </View>
                            <View style={[glSt.bgF6F4EE,glSt.mb16,glSt.jubetween,glSt.px14,glSt.py20,glSt.flex,glSt.alcenter,{flexWrap:"wrap"}]}>
                                {Array.from({length: 8}).map((_, index) => (
                                    <View key={"s2"+index} style={[index % 4 != 0 && {marginLeft:horizontalScale(24)},{marginBottom:verticalScale(26),borderRadius:50,backgroundColor:"#FFFFFF",borderWidth:1,borderColor:"#E9E6E0",width:horizontalScale(50),height:horizontalScale(50)}]}>

                                    </View>
                                ))}
                            </View>
                        </View>
                    </View>
                    }
                </Modal>
                
                <Modal isVisible={infoview}style={{margin: 0,justifyContent:"center",alignItems:"center"}}  onBackdropPress={async () => await setIsModalVisible(false)} hideModalContentWhileAnimating={true} backdropTransitionOutTiming={0}>
                    <View style={[glSt.bgFDFBF5,{flex:1,width:"100%"}]}>
                        <View style={[glSt.h58,glSt.alend,glSt.jucenter,glSt.px24]}>
                            <TouchableOpacity onPress={() => setInfoview(false)}>
                                <Image source={Images.icon_close_dark} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />    
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.px24]}>
                            <Text style={[glSt.c000000,glSt.text18b]}>스탬프 및 QR 이용안내</Text>
                        </View>
                    </View>
                </Modal>
                <Modal
                    visible={caview}
                    transparent={false}
                    animationType="slide"
                    onRequestClose={() => setModalVisible(false)}
                >
                    <Camera
                        style={StyleSheet.absoluteFill}
                        device={device}
                        isActive={true}
                        frameProcessorFps={2}
                        codeScanner={codeScanner}
                    />
                    <TouchableOpacity onPress={() => setCaview(false)} style={{position:"absolute",top:30,right:30}}>
                        <Image source={Images.icon_close_white} style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                    </TouchableOpacity>
                </Modal>
            </SafeAreaView>
        </SafeAreaProvider>
    );
};
const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    paddingHorizontal: 20,
  },
  button: {
    backgroundColor: '#322A24',
    padding: 14,
    borderRadius: 10,
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
  },
  closeButton: {
    padding: 14,
    backgroundColor: '#ccc',
    alignItems: 'center',
  },
  closeText: {
    fontSize: 16,
    color: '#000',
  },
});