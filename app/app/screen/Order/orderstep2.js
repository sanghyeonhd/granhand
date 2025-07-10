import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { AutoSizeRemoteImage, Image, Text } from "../../components/index";

import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';
import Modal from "react-native-modal";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import AlertModal from "../../components/AlertModal";
import { useFocusEffect } from '@react-navigation/native';
import Axios from "../../utils/Axios";
import DropDownPicker from 'react-native-dropdown-picker';
import Postcode from '@actbase/react-daum-postcode';

const Orderstep2 = (props) => {
    


    const [ loading, setLoading ]  = useState(true)
    const [ allok, setAllok ]  = useState(false)

    const [ datas, setdatas ] = useState();
    const [ datalist, setDatalist ] = useState([]);
    const [ addrlist, setAddrlist ] = useState([]);

    const [ citems, setCitems ] = useState([]);

    const [ isModaladdr, setIsModaladdr ] = useState(false);
    const [ isModaladdrw, setIsModaladdrw ] = useState(false);
    const [ isPost, setIsPost ] = useState(false);
    
    const [ modalVisible , setModalVisible ] = useState(false);
    const [ showmsg , setShowmsg ] = useState({
                title:"",
                message:"",
                isone : true,
                confirmText:"",
                cancelText:"",
                movetype:0
    })


    const [ inaddr, setInaddr ] = useState({
        isbasic : "N",
        name : "",
        delname : "",
        delcp : "",
        delzip : "",
        deladdr1:"",
        deladdr2:""
    })

    const updateField = (key, value) => {
        setInaddr(prev => ({
            ...prev,
            [key]: value
        }));
    };

    const [open, setOpen] = useState(false); // 드롭다운 열림 여부
    const [value, setValue] = useState(null); // 선택된 값
    const [items, setItems] = useState([
        { label: '5,000원 할인 쿠폰', value: '5000' },
        { label: '6,000원 할인 쿠폰', value: '6000' },
        { label: '2,000원 할인 쿠폰', value: '2000' },
    ]);

    const [inputs, setInputs] = useState({
            allcheck: false,
            check1: false,
            check2: false,
            check3: false,
    });

    function checkall()	{
		if(allcheck)	{
			setInputs({
				allcheck:false,
				check1: false,
                check2: false,
                check3: false,
			});
		}
		else{
			setInputs({
				allcheck:true,
				check1: true,
                check2: true,
                check3: true,
			});
		}
	}
    
    const { allcheck, check1, check2, check3 } = inputs;


    useFocusEffect(
        React.useCallback(() => {
            console.log(props.route.params);
            if(props.route.params?.items)   {
                setCitems(props.route.params.items);
            }
}       , [props.route.params])
    );

    useEffect(() => {
        if(citems.length > 0){
            get_orderinfo()
        }
    },[citems]);


    async function get_orderinfo() {
        setLoading(false);

        const param = {
            selected: citems
        };

        console.log(param);

        await Axios.jsonpost('&act=order&han=get_orderinfo&&mem_idx='+props.baseData.userData.idx,param,
            (response) => {
                console.log(response);
                setDatalist(response.datalist);
                setAddrlist(response.addrlist);
                setLoading(true);
            },
            (error) => console.log(error)
        );
    }

    const areFieldsFilled = Object.entries(inaddr).filter(([key]) => key !== "isbasic").every(([_, value]) => value.trim() !== "");

    async function saveaddr() {
        if(!areFieldsFilled)    {
             setShowmsg({title:"알림",
                isone:true,
                message:"모든항목을 입력하세요.",
                confirmText:"로그인",
                cancelText:"닫기",movetype:0})
            setModalVisible(true);
        }   else    {
             setShowmsg({title:"알림",
                isone:false,
                message:"배송지를 입력하시겠습니까?",
                confirmText:"저장",
                cancelText:"닫기",movetype:1})
            setModalVisible(true);
        }
    }

    async function profunc(m)   {
        if(m == 1)  {
            const param = {
                selected: inaddr
            };

            await Axios.jsonpost('&act=order&han=set_addr&&mem_idx='+props.baseData.userData.idx,param,
                (response) => {
                    console.log(response);
                    setAddrlist(response.addrlist);
                    setInaddr({
                        isbasic : "N",
                        name : "",
                        delname : "",
                        delcp : "",
                        delzip : "",
                        deladdr1:"",
                        deladdr2:""
                    })
                    setIsModaladdrw(false);
                },
                (error) => console.log(error)
            );
        }
    }




    if(loading) {

        return (
            <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"결제하기"} navigation={props.navigation}>
                <KeyboardAwareScrollView contentContainerStyle={[glSt.px24,{ flexGrow: 1 }]}>
                    <View style={[glSt.h54,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <Text style={[glSt.text14b,glSt.c322A24]}>배송정보</Text>
                        <TouchableOpacity onPress={() => setIsModaladdr(true)}>
                            <Text style={[glSt.text12b,glSt.cC0BCB6]}>배송지 목록</Text>
                        </TouchableOpacity>
                    </View>
                    {addrlist.length == 0 ?
                    <View style={[glSt.mb24]}>
                        <View style={[glSt.mb16]}>
                            <TouchableOpacity onPress={() => setIsModaladdr(true)} style={[glSt.h46,glSt.alcenter,glSt.jucenter,{borderWidth:1,borderColor:"#C0BCB6"}]}>
                                <Text style={[glSt.c322A24,glSt.text14b]}>새 배송지 추가</Text>
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.bgF6F4EE,glSt.px16,glSt.py16]}>
                            <View style={[]}>
                                <Text style={[glSt.text10m,glSt.c6F6963]}>정확한 배송을 위해 도로명 주소만 사용합니다.</Text>
                                <Text style={[glSt.text10m,glSt.c6F6963]}>배송지 불분명으로 반송되지 않도록 한 번 더 확인해 주세요.</Text>
                            </View>
                        </View>
                    </View>
                    :
                    <View style={{borderWidth:1,borderColor:"#E9E6E0"}}>
                        {addrlist.filter(item => item.issel === "Y").map((item, index) => (
                        <View style={[glSt.px16,glSt.py16]}>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb10]}       >
                                <View style={[glSt.flex,glSt.alcenter]}>
                                    <View style={[glSt.mr10]}>
                                        <Image source={item.issel == 'Y' ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                                    </View>
                                    <View style={[glSt.mr10]}>
                                        <Text style={[glSt.c322A24,glSt.text14b]}>{item.name}</Text>    
                                    </View>
                                    {item.isbasic == "Y" &&
                                    <Text style={[glSt.c6F6963,glSt.text10b]}>기본배송지</Text>    
                                    }
                                </View>
                                <View style={[glSt.flex,glSt.alcenter]}>
                                        
                                </View>
                            </View>
                            <View style={[glSt.mb4]}>
                                <Text style={[glSt.c322A24,glSt.text12m]}>{item.delname}</Text>
                            </View>
                            <View style={[glSt.mb4]}>
                                <Text style={[glSt.c322A24,glSt.text12m]}>{item.delcp}</Text>
                            </View>
                            <View style={[glSt.mb4]}>
                                <Text style={[glSt.c322A24,glSt.text12m]}>{item.deladdr1} {item.deladdr2}</Text>
                            </View>
                        </View>
                        ))}
                    </View>
                    }
                    
                    <View style={[glSt.h54,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <Text style={[glSt.text14b,glSt.c322A24]}>배송 요청사항</Text>
                        
                    </View>
                    <View style={[glSt.mb24]}>
                        <DropDownPicker
                            open={open}
                            value={value}   
                            items={[]}
                            disabled={items.length === 0}
                            setOpen={setOpen}
                            setValue={setValue}
                            setItems={setItems}
                            listMode="SCROLLVIEW"
                            placeholder="배송요청사항 선택"
                            style={[glSt.bgFDFBF5,{ borderColor: '#C0BCB6',borderRadius:0 }]}
                            textStyle={[glSt.c6F6963,glSt.text10b]}
                            dropDownContainerStyle={{ backgroundColor: '#FDFBF5', borderColor: '#C0BCB6',borderRadius:0 }}
                        />
                    </View>
                    <View style={[glSt.h54,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <Text style={[glSt.text14b,glSt.c322A24]}>주문 상품 정보</Text>
                        
                    </View>
                    <View>
                        <View style={{marginBottom:verticalScale(24),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                            <View style={[glSt.px16,glSt.py16]}>

                            </View>
                        </View>
                    </View>
                    <View style={[glSt.h54,glSt.flex,glSt.alcenter]}>
                        <Text style={[glSt.text14b,glSt.c322A24]}>사용 가능 쿠폰</Text>
                        <View style={[glSt.ml10]}>
                            <Image source={Images.icon_help} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                    </View>
                    <View style={[glSt.mb24]}>
                        <DropDownPicker
                            open={open}
                            value={value}   
                            items={[]}
                            disabled={items.length === 0}
                            setOpen={setOpen}
                            setValue={setValue}
                            setItems={setItems}
                            listMode="SCROLLVIEW"
                            placeholder="할인 쿠폰 선택"
                            style={[glSt.bgFDFBF5,{ borderColor: '#C0BCB6',borderRadius:0 }]}
                            textStyle={[glSt.c6F6963,glSt.text10b]}
                            dropDownContainerStyle={{ backgroundColor: '#FDFBF5', borderColor: '#C0BCB6',borderRadius:0 }}
                        />
                    </View>
                    <View style={[glSt.h54,glSt.flex,glSt.alcenter]}>
                        <Text style={[glSt.text14b,glSt.c322A24]}>포인트</Text>
                        <View style={[glSt.ml10]}>
                            <Image source={Images.icon_help} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                    </View>
                    <View style={[glSt.mb24]}>
                        <View style={[glSt.mb16,glSt.flex,glSt.alcenter]}>
                            <View style={[{flex:1},glSt.mr12,glSt.borderC0BCB6,glSt.h46,glSt.px16]}>
                                <TextInput value={0} />
                            </View>
                            <TouchableOpacity style={[glSt.bg322A24,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.px16]}>
                                <Text style={[glSt.text14b,glSt.cFFFFFF]}>전체 사용</Text>
                            </TouchableOpacity>
                        </View>
                        <View style={{marginBottom:verticalScale(24),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                            <View style={[glSt.h52,glSt.alcenter,glSt.jubetween,glSt.flex,glSt.px24]}>
                                <Text style={[glSt.c6F6963,glSt.text12b]}>시용 가능한 포인트</Text>
                                <Text style={[glSt.c6F6963,glSt.text12b]}>0</Text>
                            </View>
                        </View>
                    </View>
                    <View style={[glSt.h54,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <Text style={[glSt.text14b,glSt.c322A24]}>결제수단</Text>
                        
                    </View>
                    <View style={[glSt.mb24]}>
                        <View style={[glSt.mb16,glSt.flex,glSt.alcenter]}>
                            <View style={[glSt.mr3]}>
                                <Image source={Images.icon_radio_off} style={{width:horizontalScale(14),height:horizontalScale(14)}} />
                            </View>
                            <Text style={[glSt.c6F6963,glSt.text12m]}>간편 결제</Text>
                        </View>
                        <View style={[glSt.mb24]}>

                        </View>
                        <View style={[glSt.mb16,glSt.flex,glSt.alcenter]}>
                            <View style={[glSt.mr3]}>
                                <Image source={Images.icon_radio_off} style={{width:horizontalScale(14),height:horizontalScale(14)}} />
                            </View>
                            <Text style={[glSt.c6F6963,glSt.text12m]}>일반 결제</Text>
                        </View>
                        <View style={[glSt.mb24]}>

                        </View>
                    </View>
                    <View style={[glSt.bgF6F4EE,glSt.px16,glSt.py16,glSt.mb24]}>
                        <View style={[]}>
                            <Text style={[glSt.text10m,glSt.c6F6963]}>무통장 입금은 영업일 기준 24시간 이내 확인됩니다.</Text>
                            <Text style={[glSt.text10m,glSt.c6F6963]}>주문 후 72시간 이내에 미입금 시 자동 취소됩니다.</Text>
                        </View>
                    </View>
                    <View style={[glSt.h54,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <Text style={[glSt.text14b,glSt.c322A24]}>최종 결제 금액</Text>
                        
                    </View>
                    <View style={{marginBottom:verticalScale(24),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                        <View style={[glSt.px16,glSt.py16]}>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb8]}>
                                <Text style={[glSt.text12r,glSt.cC0BCB6]}>상품금액</Text>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>0원</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb8]}>
                                <Text style={[glSt.text12r,glSt.cC0BCB6]}>배송비</Text>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>0원</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb8]}>
                                <Text style={[glSt.text12r,glSt.cC0BCB6]}>쿠폰 할인</Text>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>0원</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb8]}>
                                <Text style={[glSt.text12r,glSt.cC0BCB6]}>포인트 사용</Text>
                                <Text style={[glSt.text12r,glSt.c6F6963]}>0원</Text>
                            </View>
                            <View style={{borderTopWidth: 1,borderTopColor: '#E9E6E0',borderStyle: 'dashed',paddingTop:verticalScale(16)}}>
                                <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb8]}>
                                    <Text style={[glSt.text12b,glSt.c322A24]}>결제 금액</Text>
                                    <Text style={[glSt.text16b,glSt.c322A24]}>0원</Text>
                                </View>
                            </View>
                        </View>
                    </View>
                    <View style={[glSt.h54,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <Text style={[glSt.text14b,glSt.c322A24]}>적립 예정 포인트</Text>
                        <Text style={[glSt.text14b,glSt.c111111]}>+0</Text>
                    </View>
                    <View style={[glSt.bgF6F4EE,glSt.px16,glSt.py16]}>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <View style={[glSt.mr10]}>
                                <Image source={Images.icon_info} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                            </View>
                            <Text style={[glSt.text10m,glSt.c6F6963]}>구매 확정 시 회원 등급별 혜택에 따라 포인트가 지급됩니다.</Text>
                        </View>
                    </View>
                    <View style={[glSt.h54,glSt.flex,glSt.alcenter,glSt.juend]}>
                        <View style={[glSt.mr10]}>
                            <Text style={[glSt.text12b,glSt.c322A24]}>합계</Text>
                        </View>
                        <Text style={[glSt.text18b,glSt.c322A24]}>0원</Text>
                    </View>
                    <View style={[glSt.flex,glSt.alcenter,glSt.py16,{borderTopColor:"#E9E6E0",borderTopWidth:1}]}>
                        <View style={[glSt.mr16]}>
                            <TouchableOpacity onPress={() => checkall()}>
                                <Image source={ Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <Text style={[glSt.text12b,glSt.c6F6963]}>주문 내용을 확인했으며, 아래 내용에 모두 동의합니다.</Text>
                        </View>
                    </View>
                    <View style={[glSt.flex,glSt.alcenter,glSt.pt16,glSt.mb8,{borderTopWidth: 1,borderTopColor: '#E9E6E0',borderStyle: 'dashed',}]}>
                        <View style={[glSt.mr16]}>
                            <TouchableOpacity onPress={() => setInputs({...inputs,check1:!check1})}>
                                <Image source={Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                            </TouchableOpacity>
                        </View>
                       <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,{flex:1}]}>
                            <View style={[glSt.flex,glSt.alcenter]}>
                                <View style={[glSt.mr8]}>
                                    <Text style={[glSt.c6F6963,glSt.text12r]}>(필수)</Text>
                                </View>
                                <TouchableOpacity style={[glSt.mr2]}>
                                    <Text style={[glSt.c6F6963,glSt.text12b]}>개인정보 수집 • 이용 동의</Text>
                                </TouchableOpacity>
                             </View>
                            <Image source={Images.icon_rarrow1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                    </View>
                    <View style={[glSt.flex,glSt.alcenter,glSt.mb8]}>
                        <View style={[glSt.mr16]}>
                            <TouchableOpacity onPress={() => setInputs({...inputs,check2:!check2})}>
                                <Image source={Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,{flex:1}]}>
                            <View style={[glSt.flex,glSt.alcenter]}>
                                <View style={[glSt.mr8]}>
                                    <Text style={[glSt.c6F6963,glSt.text12r]}>(필수)</Text>
                                </View>
                                <TouchableOpacity style={[glSt.mr2]}>
                                    <Text style={[glSt.c6F6963,glSt.text12b]}>개인정보 제3자 정보 제공 동의</Text>
                                </TouchableOpacity>
                             </View>
                            <Image source={Images.icon_rarrow1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                    </View>
                    <View style={[glSt.flex,glSt.alcenter,glSt.mb16]}>
                        <View style={[glSt.mr16]}>
                            <TouchableOpacity onPress={() => setInputs({...inputs,check3:!check3})}>
                                <Image source={Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,{flex:1}]}>
                             <View style={[glSt.flex,glSt.alcenter]}>
                                <View style={[glSt.mr8]}>
                                    <Text style={[glSt.c6F6963,glSt.text12r]}>(필수)</Text>
                                </View>
                                <TouchableOpacity style={[glSt.mr2]}>
                                    <Text style={[glSt.c6F6963,glSt.text12b]}>결제대행 서비스 이용약관 동의</Text>
                                </TouchableOpacity>
                             </View>
                            <Image source={Images.icon_rarrow1} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </View>
                    </View>
                </KeyboardAwareScrollView>
                <View style={[glSt.px24,glSt.pt16,glSt.pb24]}>   
                    <TouchableOpacity style={[allok ? glSt.bgDBD7D0 : glSt.bg322A24,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                        <Text style={[glSt.text14b,glSt.cFFFFFF]}>결제하기</Text>
                    </TouchableOpacity>
                </View>
                <Modal isVisible={isModaladdr} style={{margin: 0,justifyContent:"center",alignItems:"center"}}  onBackdropPress={() => setIsModaladdr(false)}>
                    <View style={[glSt.bgFDFBF5,{flex:1,width:"100%"}]}>
                        <View style={[glSt.h58,glSt.px24,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.flex,glSt.alcenter]}>
                                <TouchableOpacity onPress={() => setIsModaladdr(false)} style={[glSt.mr24]}>
                                    <Image source={Images.icon_back} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                                </TouchableOpacity>
                                <Text style={[glSt.text18b,glSt.c322A24]}>배송지 목록</Text>
                            </View>
                        </View>
                        <View style={[{flex:1},glSt.px24]}>
                            <View style={[glSt.pt54,glSt.mb32]}>
                                <TouchableOpacity onPress={() => setIsModaladdrw(true)} style={[glSt.h46,glSt.alcenter,glSt.jucenter,{borderWidth:1,borderColor:"#C0BCB6"}]}>
                                    <Text style={[glSt.c322A24,glSt.text14b]}>새 배송지 추가</Text>
                                </TouchableOpacity>  
                            </View>
                            {addrlist.length == 0 &&
                            <View style={[{flex:1},glSt.alcenter,glSt.jucenter]}>
                                <Text style={[glSt.cC0BCB6,glSt.text14m]}>새 배송지를 추가해 주세요.</Text>
                            </View>
                            }
                            
                            {addrlist.map((item,index) => (
                            <View key={"dels"+index} style={[item.issel=='Y' ?glSt.border6F6963 : glSt.BorderE9E6E0 ,glSt.px16,glSt.py16,glSt.mb16]}>
                                <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb10]}       >
                                    <View style={[glSt.flex,glSt.alcenter]}>
                                        <View style={[glSt.mr10]}>
                                            <TouchableOpacity>
                                                <Image source={item.issel == 'Y' ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                                            </TouchableOpacity>
                                        </View>
                                        <View style={[glSt.mr10]}>
                                            <Text style={[glSt.c322A24,glSt.text14b]}>{item.name}</Text>    
                                        </View>
                                        {item.isbasic == "Y" &&
                                        <Text style={[glSt.c6F6963,glSt.text10b]}>기본배송지</Text>    
                                        }
                                    </View>
                                    <View style={[glSt.flex,glSt.alcenter]}>
                                        <TouchableOpacity>
                                            <Text style={[glSt.text12b,glSt.cDBD7D0]}>수정</Text>
                                        </TouchableOpacity>
                                        <View style={{width:1,backgroundColor:"#E9E6E0",height:verticalScale(8),marginHorizontal:horizontalScale(10)}}></View>
                                        <TouchableOpacity>
                                            <Text style={[glSt.text12b,glSt.cDBD7D0]}>삭제</Text>
                                        </TouchableOpacity>
                                    </View>
                                </View>
                                <View style={[glSt.mb4]}>
                                    <Text style={[glSt.c322A24,glSt.text12m]}>{item.delname}</Text>
                                </View>
                                <View style={[glSt.mb4]}>
                                    <Text style={[glSt.c322A24,glSt.text12m]}>{item.delcp}</Text>
                                </View>
                                <View style={[glSt.mb4]}>
                                    <Text style={[glSt.c322A24,glSt.text12m]}>{item.deladdr1} {item.deladdr2}</Text>
                                </View>
                            </View>
                            ))}
                        </View>
                         <View style={[glSt.px24,glSt.pb24]}>
                            <TouchableOpacity onPress={() => setIsModaladdr(false)} style={[addrlist.length == 0 ? glSt.bgDBD7D0 : glSt.bg322A24 ,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                                <Text style={[glSt.text14b,glSt.cFFFFFF]}>선택 완료</Text>
                            </TouchableOpacity>
                        </View>
                        
                    </View>
                    
                </Modal>
                <Modal isVisible={isModaladdrw} style={{margin: 0,justifyContent:"center",alignItems:"center"}}  onBackdropPress={() => setIsModaladdrw(false)}>
                    <View style={[glSt.bgFDFBF5,{flex:1,width:"100%"}]}>
                        <View style={[glSt.h58,glSt.px24,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                            <View style={[glSt.flex,glSt.alcenter]}>
                                <TouchableOpacity onPress={() => setIsModaladdrw(false)} style={[glSt.mr24]}>
                                    <Image source={Images.icon_back} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                                </TouchableOpacity>
                                <Text style={[glSt.text18b,glSt.c322A24]}>배송지 입력</Text>
                            </View>
                        </View>
                       <KeyboardAwareScrollView contentContainerStyle={[glSt.px24,{ flexGrow: 1 }]}>
                            <View style={[glSt.pt16,glSt.pb16,glSt.flex,glSt.alcenter]}>
                                <View style={[glSt.mr16]}>
                                    <TouchableOpacity onPress={() => setInaddr(prev => ({
                                        ...prev,
                                        isbasic: prev.isbasic === "Y" ? "N" : "Y"}))}>
                                        <Image source={inaddr.isbasic == 'Y' ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />
                                    </TouchableOpacity>
                                </View>
                                <Text style={[glSt.c322A24,glSt.text12r]}>기본 배송지</Text>
                            </View>
                            <View style={[glSt.mb24]}>
                                <View style={glSt.mb8}>
                                    <Text style={[glSt.text14m,glSt.c322A24]}>배송지명</Text>
                                </View>
                                <View style={[glSt.h46,glSt.px16,glSt.borderC0BCB6]}>
                                    <TextInput placeholder={"배송지명을 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} value={inaddr.name} onChangeText={(text) => updateField("name", text)}/>
                                </View>
                                
                            </View>
                            <View style={[glSt.mb24]}>
                                <View style={glSt.mb8}>
                                    <Text style={[glSt.text14m,glSt.c322A24]}>받는 분</Text>
                                </View>
                                <View style={[glSt.h46,glSt.px16,glSt.borderC0BCB6]}>
                                    <TextInput placeholder={"성함을 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]}  value={inaddr.delname} onChangeText={(text) => updateField("delname", text)} />
                                </View>
                                
                            </View>
                            <View style={[glSt.mb24]}>
                                <View style={glSt.mb8}>
                                    <Text style={[glSt.text14m,glSt.c322A24]}>연락처</Text>
                                </View>
                                <View style={[glSt.h46,glSt.px16,glSt.borderC0BCB6]}>
                                    <TextInput placeholder={"연락처를 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]}  value={inaddr.delcp} onChangeText={(text) => updateField("delcp", text)}  />
                                </View>
                                
                            </View>
                            <View style={[glSt.mb24]}>
                                <View style={glSt.mb8}>
                                    <Text style={[glSt.text14m,glSt.c322A24]}>주소</Text>
                                </View>
                                <View style={[glSt.flex,glSt.alcenter,glSt.mb10]}>
                                    <View style={[glSt.h46,glSt.px16,glSt.borderC0BCB6,glSt.mr12,{flex:1}]}>
                                        <TextInput placeholder={"우편번호 찾기"} style={[glSt.text14r,glSt.c322A24]} value={inaddr.delzip} onChangeText={(text) => updateField("delzip", text)}  />
                                    </View>
                                    <TouchableOpacity onPress={() => setIsPost(true)} style={[glSt.bg322A24,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.px16]}>
                                        <Text style={[glSt.text14b,glSt.cFFFFFF]}>검색</Text>
                                    </TouchableOpacity>
                                </View>
                                
                                <View style={[glSt.h46,glSt.px16,glSt.borderC0BCB6,glSt.mb10]}>
                                    <TextInput placeholder={"주소를 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} value={inaddr.deladdr1} onChangeText={(text) => updateField("deladdr1", text)}  />
                                </View>
                                
                                <View style={[glSt.h46,glSt.px16,glSt.borderC0BCB6]}>
                                    <TextInput placeholder={"상세주소를 입력해 주세요."} style={[glSt.text14r,glSt.c322A24]} value={inaddr.deladdr2} onChangeText={(text) => updateField("deladdr2", text)}  />
                                </View>
                            </View>
                        </KeyboardAwareScrollView>
                        <View style={[glSt.px24,glSt.pb24]}>
                            <TouchableOpacity onPress={() => saveaddr()} style={[ areFieldsFilled ? glSt.bg322A24 : glSt.bgDBD7D0,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                                <Text style={[glSt.text14b,glSt.cFFFFFF]}>저장</Text>
                            </TouchableOpacity>
                        </View>
                    </View>
                </Modal>
                <Modal isVisible={isPost}>
                    <View style={[glSt.flex,glSt.alcenter,glSt.jucenter]}>
                        <Postcode
                            style={{ width: 320, height:500 }}
                            jsOptions={{ animation: true, hideMapBtn: true }}
                            onSelected={data => {
                                setInaddr(prev => ({
                                    ...prev,
                                    deladdr1: data.roadAddress || "",
                                    delzip: data.zonecode || ""
                                }));
                                setIsPost(false);
                            }}
                            />
                    </View>
                </Modal>
                <AlertModal
                    visible={modalVisible}
                    oneButton={showmsg.isone}
                    title={showmsg.title}
                    message={showmsg.message}
                    confirmText={showmsg.confirmText}
                    cancelText={showmsg.cancelText}
                    onConfirm={() => {
                        console.log('이동 버튼 눌림');
                        profunc(showmsg.movetype)
                    }}
                    onCancel={() => {
                        console.log('취소 버튼 눌림');
                    }}
                    onClose={() => setModalVisible(false)}
                />

            </Layout>
        );

    }   else{
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
)(Orderstep2);