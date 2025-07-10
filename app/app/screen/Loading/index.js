import React, { useState, useEffect } from "react";
import { Platform, View, ouchableOpacity, Image, TouchableOpacity, ImageBackground } from "react-native";
import {SafeAreaView, SafeAreaProvider} from 'react-native-safe-area-context';
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Text } from "../../components/index";
import AsyncStorage from '@react-native-async-storage/async-storage';

import {PERMISSIONS, RESULTS, requestMultiple} from 'react-native-permissions';

import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome'
import { faPhone, faLocationArrow, faCamera } from '@fortawesome/free-solid-svg-icons'
import { horizontalScale, verticalScale } from "../../utils/Scale";
import glSt from "../../assets/styles/glSt";

export default Loading = ({ baseData, navigation, login }) => {

    const [isNew, setIsNew ] = useState(false);

    useEffect(() => {


        checkFirst();

        

    },[]);

    
	

    async function checkFirst() {
		const value = await AsyncStorage.getItem('@isNew');
		console.log(value)
		if(value === null) {
			setIsNew(true)
		}
		else    {
			getData();
		}
	}

    async function serPrig() {
		await AsyncStorage.setItem('@isNew', "N");
        setIsNew(false);
		getData();
	}

    async function getData()  {
		const hasLocationPermission = await permissionCheck();
		
        try {
            const value = await AsyncStorage.getItem('@isFirst');
			//console.log(value);
            if(value !== null) {
				setTimeout(() => {
					navigation.replace("Home");
				}, 2000);

            }
            else    {
				setTimeout(() => {
					navigation.replace("Home");
				}, 2000);


            }
        } catch(e) {

        }
    }

    function checkJoin(phone)	{
        
	}

    async function permissionCheck() {
		if (Platform.OS === 'ios') {
			return true;
		}

		if(Platform.Version<30)	{

			try {
				
				const result = await requestMultiple([PERMISSIONS.ANDROID.ACCESS_FINE_LOCATION, PERMISSIONS.ANDROID.CAMERA, PERMISSIONS.ANDROID.CALL_PHONE]).then((statuses) => {
					
				});

				return true;
			  } catch (error) {
				console.log('askPermission', error);
				return false;
			}

		}
		else{
			try {
				
				const result = await requestMultiple([ PERMISSIONS.ANDROID.ACCESS_FINE_LOCATION, PERMISSIONS.ANDROID.CAMERA, PERMISSIONS.ANDROID.CALL_PHONE]).then((statuses) => {
					console.log(statuses);
				});

				return true;
			  } catch (error) {
				console.log('askPermission', error);
				return false;
			}
		}
    }

    if(isNew)	{
        return (
			<SafeAreaProvider>
				<SafeAreaView style={{flex:1,backgroundColor:"#FFFFFF"}}>
					<View style={{flexDirection:"column",justifyContent:"space-between",flex:1,backgroundColor:"#FFFFFF",paddingHorizontal:horizontalScale(24)}}>
						<View style={{}}>
							<View style={{height:verticalScale(58),justifyContent:"center"}}>
								<Image source={Images.logo} width={109} height={14} style={{width:horizontalScale(109),height:horizontalScale(14)}} />
							</View>
							<View style={{paddingTop:verticalScale(54),paddingBottom:verticalScale(16)}}>
								<Text style={[glSt.f18,glSt.c322A24,glSt.f700,{textAlign: 'center'}]}>앱 접근 권한 안내</Text>
							</View>
							<View>
								<Text style={[glSt.f12,glSt.c6F6963,glSt.f500,{textAlign: 'center'}]}>그랑핸드의 다양한 서비스 제공을 위해</Text>
							</View>
							<View style={{paddingBottom:verticalScale(40)}}>
								<Text style={[glSt.f12,glSt.c6F6963,glSt.f500,{textAlign: 'center'}]}>아래와 같은 기능이 필요합니다.</Text>
					
							</View>
							<View style={{height:verticalScale(54),paddingBottom:verticalScale(10)}}>
								<Text style={[glSt.f14,glSt.c322A24,glSt.f700]}>선택적 접근 권한</Text>
							</View>
							<View style={{flexDirection:"row",alignItems:"center",marginBottom:verticalScale(16)}}>
								<Image source={Images.alarm} width={24} height={24} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
								<View style={{paddingLeft:horizontalScale(24)}}>
									<Text style={[glSt.c6F6963,glSt.f500,glSt.f14]}>알림(선택)</Text>
									<Text style={[glSt.cC0BCB6,glSt.f500,glSt.f14]}>이벤트 및 공지, 주문 알림 시 사용</Text>
								</View>
							</View>
							<View style={{flexDirection:"row",alignItems:"center",marginBottom:verticalScale(16)}}>
								<Image source={Images.camera} width={24} height={24} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
								<View style={{paddingLeft:horizontalScale(24)}}>
									<Text style={[glSt.c6F6963,glSt.f500,glSt.f14]}>카메라(선택)</Text>
									<Text style={[glSt.cC0BCB6,glSt.f500,glSt.f14]}>QR코드 인식 및 이미지 첨부 시 사용</Text>
								</View>
							</View>
							<View style={{flexDirection:"row",alignItems:"center",marginBottom:verticalScale(16)}}>
								<Image source={Images.photo} width={24} height={24} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
								<View style={{paddingLeft:horizontalScale(24)}}>
									<Text style={[glSt.c6F6963,glSt.f500,glSt.f14]}>사진(선택)</Text>
									<Text style={[glSt.cC0BCB6,glSt.f500,glSt.f14]}>페이지 공유 및 이미지 저장 / 첨부 시 사용</Text>
								</View>
							</View>

						</View>
						<View style={{backgroundColor:"#322A2408",paddingHorizontal:horizontalScale(16),paddingVertical:horizontalScale(16)}}>
							<View style={{paddingBottom:verticalScale(4),flexDirection:"row",alignItems:"center"}}>
								<View style={{width: 2,height: 2,borderRadius: 3,backgroundColor: '#322A24',marginRight: 8,}} />
								<Text style={[glSt.f10,glSt.c322A24,glSt.f500]}>선택적 접근 권한은 해당 기능을 사용할 때만 허용이 필요합니다.</Text>
							</View>
							<View style={{paddingBottom:verticalScale(4),flexDirection:"row",alignItems:"center"}}>
								<View style={{width: 2,height: 2,borderRadius: 3,backgroundColor: '#322A24',marginRight: 8,}} />
								<Text style={[glSt.f10,glSt.c322A24,glSt.f500]}>비허용 시에도 해당 기능 외 서비스 이용이 가능합니다. 허용 상태는</Text>
							</View>
							<View style={{paddingBottom:verticalScale(4),flexDirection:"row",alignItems:"center"}}>
								<View style={{width: 2,height: 2,borderRadius: 3,backgroundColor: "#322A2408",marginRight: 8,}} />
								<Text style={[glSt.f10,glSt.c322A24,glSt.f500]}>휴대폰 설정 메뉴에서 언제든지 변경할 수 있습니다.</Text>
							</View>	
						</View>
						
						
					</View>
					<TouchableOpacity onPress={() => serPrig()} style={{marginHorizontal:horizontalScale(24),marginBottom:verticalScale(44),marginTop:verticalScale(32),height:verticalScale(46),backgroundColor:"#322A24",justifyContent:"center",alignItems:"center"}}>
						<Text style={{fontSize:16,fontWeight:"bold",color:"#FFFFFF"}}>동의하고 시작하기</Text>
					</TouchableOpacity>
				</SafeAreaView>
			</SafeAreaProvider>
        );
    }
    else{
        return (
            <View style={{flex:1,alignItems:"center",justifyContent:"center"}}>
                <Image source={Images.logo} style={{width:horizontalScale(193),height:horizontalScale(25)}} />
            </View>
        );
    }
    
};
