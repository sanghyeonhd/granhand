import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { AutoSizeRemoteImage, Image, Text } from "../../components/index";

import VersionCheck from 'react-native-version-check';
import Modal from "react-native-modal";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import AlertModal from "../../components/AlertModal";
import { useFocusEffect } from '@react-navigation/native';
import Axios from "../../utils/Axios";

const Cart = (props) => {
    

    const [ loading, setLoading ]  = useState(false)

    const [ datas, setdatas ] = useState();
    const [ datalist, setDatalist ] = useState([]);
    const [ selitems, setSelitems ]  = useState(0);

    const [ modalVisible , setModalVisible ] = useState(false);
    const [ showmsg , setShowmsg ] = useState({
            title:"",
            message:"",
            isone : true,
            confirmText:"",
            cancelText:"",
            movetype:0
    })

    useFocusEffect(
        React.useCallback(() => {
            if(props.baseData.isLogin){
                 get_goods()
            }
        }, [])
    );

    async function get_goods() {
        console.log("aaa");
        setLoading(false);
        await Axios.get('&act=order&han=get_cart&&mem_idx='+props.baseData.userData.idx,
            (response) => {
                console.log(response.cart);
                setDatalist(response.datalist);
                setdatas(response.cart);
                setSelitems(response.datalist.length);
                setTimeout(() => {
                        setLoading(true);
                }, 500); // 10000ms = 10초
            },
            (error) => console.log(error)
        );
    }

    async function updateeas(idx,ea) {

        await Axios.get('&act=order&han=upcart&&mem_idx='+props.baseData.userData.idx+'&idx='+idx+'&ea='+ea,
            (response) => {
               
            },
            (error) => console.log(error)
        );
    }

    const updateEa = (index, delta) => {
        setDatalist(prev =>
            prev.map((item, idx) => {
                if (idx === index) {
                    const currentEa = parseInt(item.ea, 10) || 1; // 숫자 변환, 실패시 1
                    const newEa = Math.max(1, currentEa + delta); // 최소 1
                    updateeas(item.idx,newEa);
                    return { ...item, ea: newEa }; // 숫자로 저장
                }
                return item;
            })
        );
    };

    const handleToggleAll = () => {
        setDatalist(prev => {
            const allSelected = prev.filter(item => item.issel === 'Y').length === prev.length;
            const newValue = allSelected ? 'N' : 'Y';
            const updated = prev.map(item => ({
                ...item,
                issel: newValue
            }));

            setSelitems(newValue === 'Y' ? updated.length : 0);
            return updated;
        });
    };

    const toggleSelect = (index) => {
        setDatalist(prev => {
            const updated = prev.map((item, idx) =>
            idx === index
                ? { ...item, issel: item.issel === 'Y' ? 'N' : 'Y' }
                : item
            );

            const selectedCount = updated.filter(item => item.issel === 'Y').length;
            console.log("선택된 항목 수:", selectedCount);
            setSelitems(selectedCount);
            return updated;
        });
    };


    useEffect(() => {
        const total = datalist.reduce((sum, item) => {
            if (item.issel == "Y") {
                const ea = parseInt(item.ea, 10) || 0;
                return sum + ea * item.account_pure;
            }
            return sum;
        }, 0);
        console.log(total)
        setdatas(prev => ({
            ...prev,
            totaltaccount: total.toLocaleString('ko-KR')
        }));

    }, [datalist]);

    function  del_select()  {
        if(selitems == 0)   {
            setShowmsg({title:"알림",
                isone:true,
                message:"삭제할 상품이 없습니다.",
                confirmText:"로그인",
                cancelText:"닫기",movetype:0})
            setModalVisible(true);
        }   else    {
            setShowmsg({title:"장바구니삭제",
                isone:false,
                message:"선택한 상품을 삭제하시겠습니까?",
                confirmText:"삭제",
                cancelText:"닫기",movetype:1})
            setModalVisible(true);
        }
    }

    async function profunc(m) {
        if(m==1)    {
            const selectedItems = datalist.filter(item => item.issel === 'Y').map(item => item.idx);

            // 전송할 JSON 데이터 구조 예시
            const param = {
                selected: selectedItems
            };
            await Axios.jsonpost('&act=order&han=delcart&&mem_idx='+props.baseData.userData.idx,param,
                (response) => {
                    get_goods()
                },
                (error) => console.log(error)
            );
        }
    }

    function gobuy()    {
        if(selitems == 0)   {
            setShowmsg({title:"알림",
                isone:true,
                message:"구매할 상품이 없습니다.",
                confirmText:"로그인",
                cancelText:"닫기",movetype:0})
            setModalVisible(true);
        }   else    {
            const selectedItems = datalist.filter(item => item.issel === 'Y').map(item => item.idx);

            props.navigation.navigate("Orderstep2",{items:selectedItems})
        }
    }

    if(loading) {

        return (
            <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={"장바구니"} navigation={props.navigation}>
                <View style={[glSt.px24,glSt.h54,glSt.flex,glSt.alcenter,glSt.jubetween,glSt.mb16]}>
                    <View style={[glSt.flex]}>
                        <TouchableOpacity onPress={() => handleToggleAll} style={[glSt.mr24]}>
                            <Image source={selitems == 0 ? Images.icon_check_off : Images.icon_check_on} style={{width:horizontalScale(16),height:horizontalScale(16)}} />    
                        </TouchableOpacity>
                        <Text style={[glSt.c322A24,glSt.text14b]}>전체 선택 ({selitems}/{datalist.length})</Text>
                    </View>
                    <TouchableOpacity onPress={() => del_select()}>
                        <Text style={[glSt.cC0BCB6,glSt.text12b]}>상품 삭제</Text>
                    </TouchableOpacity>
                </View>
                <ScrollView>

                    {datalist.length == 0 &&
                    <View style={[glSt.alcenter,glSt.jucenter,glSt.pt54]}>
                        <Text style={[glSt.cC0BCB6,glSt.text14m]}>장바구니에 담긴 상품이 없어요.</Text>
                    </View>
                    }
                    <View style={[glSt.px24]}>
                        {datalist.map((item,index) => (
                        <View key={"cart"+index} style={[glSt.flex,glSt.alstart,glSt.mb32,{flex:1}]}>
                            <View style={[glSt.mr24]}>
                                <TouchableOpacity onPress={() => toggleSelect(index)}>
                                    <Image source={item.issel == "Y" ? Images.icon_check_on : Images.icon_check_off} style={{width:horizontalScale(16),height:horizontalScale(16)}} />    
                                </TouchableOpacity>
                            </View>
                            <View style={[glSt.flex,glSt.alstart,{flex:1}]}>
                                <TouchableOpacity onPress={() => props.navigation.navigate("Shopview",{idx:item.goods_idx})} style={[glSt.mr16]}>
                                    <AutoSizeRemoteImage uri={item.simg1} basewidth={72} />
                                </TouchableOpacity>
                                <View style={[{flex:1}]}>
                                    <View style={[glSt.mb2]}>
                                        <Text style={[glSt.text12m,glSt.c000000]}>{item.gname}</Text>
                                    </View>
                                    <View style={[glSt.mb8]}>
                                        <Text style={[glSt.text14b,glSt.c322A24]}>{item.account}원</Text>
                                    </View>
                                    <View style={[glSt.flex,glSt.alcenter,glSt.jubetween]}>
                                        <View>

                                        </View>
                                        <View style={[glSt.flex,glSt.alcenter,glSt.jubetween]}>
                                            <TouchableOpacity onPress={() => updateEa(index, -1)}>
                                                <Image source={Images.icon_minus}  style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                                            </TouchableOpacity>
                                            <Text style={[glSt.px2,glSt.text12b,glSt.c322A24]}>
                                                {item.ea} 
                                            </Text>
                                            <TouchableOpacity onPress={() => updateEa(index, 1)}>
                                                <Image source={Images.icon_plus}  style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                                            </TouchableOpacity>
                                        </View>
                                    </View>
                                </View>
                            </View>
                        </View>
                        ))}
                    </View>
                    
                    
                </ScrollView>
                <View style={[{borderTopColor:"#E9E6E0",borderTopWidth:1},glSt.px24,glSt.pt16,glSt.pb24]}>
                    <View style={[glSt.alend]}>
                        <View style={[glSt.flex,glSt.alcenter,glSt.mb24]}>
                            <View style={[glSt.mr10]}>
                                <Text style={[glSt.c322A24,glSt.text12b]}>합계</Text>
                            </View>
                            <Text style={[glSt.c322A24,glSt.text18b]}>{datas.totaltaccount}원</Text> 
                        </View>
                    
                    </View>
                    <TouchableOpacity onPress={() => gobuy()} style={[selitems == 0 ? glSt.bgDBD7D0 : glSt.bg322A24,glSt.h46,glSt.alcenter,glSt.jucenter,glSt.mb16]}>
                        <Text style={[glSt.text14b,glSt.cFFFFFF]}>구매하기</Text>
                    </TouchableOpacity>
                </View>
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
)(Cart);