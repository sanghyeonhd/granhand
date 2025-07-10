import React, { useState, useEffect, useRef } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  View, TouchableOpacity, Dimensions, ScrollView, StyleSheet, Alert, ActivityIndicator, Animated , Platform, ImageBackground } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text, AutoSizeRemoteImage } from "../../components/index";
import { useFocusEffect } from '@react-navigation/native';
import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import RBSheet from 'react-native-raw-bottom-sheet';
import AlertModal from "../../components/AlertModal";

const itemwidth = (Dimensions.get("window").width - horizontalScale(64)) / 2

const Shoplist = (props) => {
    const refRBSheet1 = useRef();
    const refRBSheet2 = useRef();


    const scrollY = useRef(new Animated.Value(0)).current;
    const stickyThreshold = Dimensions.get('screen').width * 0.45;

    const [ cate, setCate ] = useState("");
    const [ loading, setLoading ]  = useState(false);

    const [ orderitems, setOrdersitems ] = useState([
        {idx:1,str:"추천순"},
        {idx:2,str:"인기순"},
        {idx:3,str:"낮은 가격순"},
        {idx:4,str:"높은 가격순"},
        {idx:5,str:"상품명 오름차순"},
        {idx:6,str:"상품명 내림차순"},
    ])

    const [ pageorder, setPageorder ] = useState({
        ob:1,
        str:"추천순"
    })

    const [ modalVisible , setModalVisible ] = useState(false);
    const [ showmsg , setShowmsg ] = useState({
        title:"",
        message:"",
        confirmText:"",
        cancelText:"",
        movetype:0
    })

    const [ datas, setDatas ] = useState({cate:[],datalist:[],subcate:[]})
    
    const stickyTranslateY = scrollY.interpolate({
        inputRange: [stickyThreshold - 1, stickyThreshold],
        outputRange: [0, 0],
        extrapolate: 'clamp',
    });

    const isSticky = scrollY.interpolate({
        inputRange: [stickyThreshold, stickyThreshold + 1],
        outputRange: [0, 1],
        extrapolate: 'clamp',
    });
    
    useFocusEffect(
        React.useCallback(() => {
            console.log(props.route.params);
            if(props.route.params?.cate)   {
                setCate(props.route.params.cate);
            }
        }, [props.route.params])
    );

    useEffect(() => {
        const fetchAll = async () => {
        try {
            const [
                cateRes,
                dataRes,
            ] = await Promise.all([
                new Promise((resolve, reject) => Axios.get('&act=shop&han=get_cate&cate='+cate, resolve, reject)),
                new Promise((resolve, reject) => Axios.get('&act=shop&han=get_list&cate='+cate+"&mem_idx="+props.baseData.userData.idx, resolve, reject)),
            ]);
            if(cate.length == 2)    {
                setDatas({
                    ...datas,
                    cate: cateRes.datas,
                    datalist: dataRes.datas,
                });
            }   else  if(cate.length == 4)    {
                setDatas({
                    ...datas,
                    subcate: cateRes.datas,
                    datalist: dataRes.datas,
                });
            }   else{
                setDatas({
                    ...datas,
                    datalist: dataRes.datas,
                });
            }
            
        } catch (e) {
            console.error('API 중 오류 발생:', e);
        } finally {
            setLoading(true);
        }};

        fetchAll();
    }, [cate]);

    async function set_wish(idx) {

        if(props.baseData.isLogin){
            await Axios.get('&act=goods&han=set_wish&goods_idx='+idx+"&mem_idx="+props.baseData.userData.idx,
            (response) => {
                if(response.res == 'ok1')   {
                    setDatas(prev => ({
                         ...prev,
                        datalist: prev.datalist.map(item =>
                        item.idx === idx ? { ...item, havewish: 'Y' } : item
                    )
                    }));
                }   else    {
                    setDatas(prev => ({
                         ...prev,
                        datalist: prev.datalist.map(item =>
                        item.idx === idx ? { ...item, havewish: 'N' } : item
                    )
                    }));
                }
            },
            (error) => console.log(error)
            );
        }   else{

            setShowmsg({title:"로그인이 필요합니다.",
                message:"로그인 하시겠습니다?",
                confirmText:"로그인",
                cancelText:"닫기",movetype:1})
            setModalVisible(true);
        }

        
    }
    
    if(loading) {
        return (
            <Layout havebottom={true} havetop={false} havnoback={false} toptext={""} navigation={props.navigation}>
                <View style={[glSt.h58,glSt.flex,glSt.alcenter,glSt.jubetween,glSt.px24]}>
                    <View style={[glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <View style={[glSt.gr8]}>
                            <Image source={Images.main1} style={{width:horizontalScale(109),height:horizontalScale(14)}} resizeMode="contain" />   
                        </View>
                        <TouchableOpacity onPress={() => refRBSheet1.current.open()}>
                            <Image source={Images.icon_more} style={{width:horizontalScale(24),height:horizontalScale(24)}}/>
                        </TouchableOpacity>
                    </View> 
                    <View style={[glSt.flex,glSt.alcenter]}>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Search")} style={[glSt.mr24]}>
                            <Image source={Images.icon_search} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Cart")} style={[]}>
                            <Image source={Images.icon_cart} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                        </TouchableOpacity>
                    </View>
                </View>
                <Animated.View
                    style={{
                        position: 'absolute',
                        top: verticalScale(58),
                        left: 0,
                        right: 0,
                        zIndex: 10,
                        opacity: isSticky,
                        transform: [{ translateY: stickyTranslateY }],
                    }}
                >
                    <View style={[{ height: verticalScale(112) },glSt.bgFDFBF5]}>
                        <View style={[glSt.h54,glSt.flex,glSt.px24,glSt.alcenter]}>
                            <TouchableOpacity onPress={() => setCate(cate.substring(0,2))} style={[glSt.mr20]}>
                                <Text style={[glSt.text14b,cate.length == 2 ? glSt.c6F6963 : glSt.cC0BCB6]}>전체</Text>
                            </TouchableOpacity>
                            {datas.cate.map((item,index) => (
                            <TouchableOpacity onPress={() => setCate(item.catecode)} key={"cate1"+index} style={[glSt.mr20]}>
                                <Text style={[glSt.text14b,cate == item.catecode ? glSt.c6F6963 : glSt.cC0BCB6]}>{item.catename}</Text>
                            </TouchableOpacity>
                            ))}
                        </View>
                        
                        {cate.length >= 4 &&
                        <View style={[glSt.h20,glSt.flex,glSt.px24,glSt.alcenter]}>
                            <TouchableOpacity onPress={() => setCate(cate.substring(0,4))} style={[glSt.mr20]}>
                                <Text style={[glSt.text12b,cate.length == 4 ? glSt.c6F6963 : glSt.cC0BCB6]}>전체</Text>
                            </TouchableOpacity>
                             {datas.subcate.map((item,index) => (
                            <TouchableOpacity onPress={() => setCate(item.catecode)} key={"cate1"+index} style={[glSt.mr20]}>
                                <Text style={[glSt.text14b,cate == item.catecode ? glSt.c6F6963 : glSt.cC0BCB6]}>{item.catename}</Text>
                            </TouchableOpacity>
                            ))}
                        </View>
                        }
                        <View style={[glSt.h38,glSt.alend,glSt.juend,glSt.px24]}>
                            <TouchableOpacity onPress={() => refRBSheet2.current.open()} style={[glSt.flex,glSt.alcenter]}>
                                <View style={[glSt.mr4]}>
                                    <Text style={[glSt.c6F6963,glSt.text12b]}>{pageorder.str}</Text>
                                </View>
                                <Image source={Images.icon_down} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                            </TouchableOpacity>       
                        </View>
                    </View>
                </Animated.View>
                <Animated.ScrollView
                    onScroll={Animated.event(
                        [{ nativeEvent: { contentOffset: { y: scrollY } } }],
                        { useNativeDriver: false }
                    )}
                    scrollEventThrottle={16}
                >
                    <ImageBackground
                        source={Images.testimg}
                        style={{
                            width: Dimensions.get('screen').width,
                            height: Dimensions.get('screen').width * 0.45,
                        }}
                        resizeMode="cover"
                    />
                    <View style={{ height: verticalScale(112) }}>
                        <View style={[glSt.h54,glSt.flex,glSt.px24,glSt.alcenter]}>
                            <TouchableOpacity onPress={() => setCate(cate.substring(0,2))} style={[glSt.mr20]}>
                                <Text style={[glSt.text14b,cate.length == 2 ? glSt.c6F6963 : glSt.cC0BCB6]}>전체</Text>
                            </TouchableOpacity>
                            {datas.cate.map((item,index) => (
                            <TouchableOpacity onPress={() => setCate(item.catecode)} key={"cate1"+index} style={[glSt.mr20]}>
                                <Text style={[glSt.text14b,cate == item.catecode ? glSt.c6F6963 : glSt.cC0BCB6]}>{item.catename}</Text>
                            </TouchableOpacity>
                            ))}
                        </View>
                        
                        {cate.length >= 4 &&
                        <View style={[glSt.h20,glSt.flex,glSt.px24,glSt.alcenter]}>
                            <TouchableOpacity onPress={() => setCate(cate.substring(0,4))} style={[glSt.mr20]}>
                                <Text style={[glSt.text12b,cate.length == 4 ? glSt.c6F6963 : glSt.cC0BCB6]}>전체</Text>
                            </TouchableOpacity>
                             {datas.subcate.map((item,index) => (
                            <TouchableOpacity onPress={() => setCate(item.catecode)} key={"cate1"+index} style={[glSt.mr20]}>
                                <Text style={[glSt.text14b,cate == item.catecode ? glSt.c6F6963 : glSt.cC0BCB6]}>{item.catename}</Text>
                            </TouchableOpacity>
                            ))}
                        </View>
                        }
                        <View style={[glSt.h38,glSt.alend,glSt.juend,glSt.px24]}>
                            <TouchableOpacity onPress={() => refRBSheet2.current.open()}  style={[glSt.flex,glSt.alcenter]}>
                                <View style={[glSt.mr4]}>
                                    <Text style={[glSt.c6F6963,glSt.text12b]}>{pageorder.str}</Text>
                                </View>
                                <Image source={Images.icon_down} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                            </TouchableOpacity>       
                        </View>
                    </View>
                    <View style={[glSt.px24,glSt.flex,glSt.alcenter]}>
                        {datas.datalist.map((item,index) => (
                        <TouchableOpacity onPress={() => props.navigation.navigate("Shopview",{idx:item.idx})} key={"list"+index} style={[glSt.mb16,index % 2 == 0 ? glSt.mr8 : glSt.ml8]}>
                            <View style={[glSt.mb8,{position:"relative"}]}>
                                <AutoSizeRemoteImage uri={item.imgurl} basewidth={itemwidth} />    
                                <TouchableOpacity onPress={() => set_wish(item.idx)} style={{position:"absolute",top:horizontalScale(16),right:horizontalScale(16 )}}>
                                     <Image source={item.havewish == 'Y' ? Images.icon_heartg_on : Images.icon_heartg_off} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                                </TouchableOpacity>
                            </View>
                            <Text style={[glSt.c000000,glSt.text14b]}>{item.gname}</Text>
                            <Text style={[glSt.cC0BCB6,glSt.text12r]}>{item.gname_pre}</Text>
                            <Text style={[glSt.c322A24,glSt.text12r]}>{item.account}</Text>
                        </TouchableOpacity> 
                        ))}
                    </View>
                </Animated.ScrollView>
                <RBSheet
                    ref={refRBSheet1}
                >
                    <View style={[glSt.px24,glSt.pt30]}>
                        <Text style={[glSt.text16b,glSt.c6F6963]}>다양한 BRAND를 만나보세요.</Text>
                        <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.py36]}>
                            <TouchableOpacity onPress={() => { setCate("01"); refRBSheet1.current.close(); } } style={[glSt.flex,glSt.alcenter,glSt.jucenter]}>
                                <Image source={Images.main1} style={{width:horizontalScale(80),height:horizontalScale(30)}} resizeMode="contain" />
                            </TouchableOpacity>
                            <View style={{width:1,height:verticalScale(36),backgroundColor:"#E9E6E0"}}></View>
                            <TouchableOpacity onPress={() => { setCate("02"); refRBSheet1.current.close(); } }  style={[glSt.flex,glSt.alcenter,glSt.jucenter]}>
                                <Image source={Images.main2} style={{width:horizontalScale(80),height:horizontalScale(30)}} resizeMode="contain" />
                            </TouchableOpacity>
                            <View style={{width:1,height:verticalScale(36),backgroundColor:"#E9E6E0"}}></View>
                            <TouchableOpacity onPress={() => { setCate("03"); refRBSheet1.current.close(); } }  style={[glSt.flex,glSt.alcenter,glSt.jucenter]}>
                                <Image source={Images.main3} style={{width:horizontalScale(80),height:horizontalScale(30)}} resizeMode="contain" />
                            </TouchableOpacity>
                        </View>
                    </View>
                </RBSheet>   
                <RBSheet
                    ref={refRBSheet2}
                    customStyles={{
                        container: {
                            height:verticalScale(300)
                        }
                    }}
                >
                    <View style={[glSt.px24,glSt.pt24]}>
                        {orderitems.map((item,index) =>(
                        <TouchableOpacity onPress={() => { setPageorder({ob:item.idx,str:item.str}); refRBSheet2.current.close() }} key={"ob"+index} style={{height:verticalScale(41)}}>
                            <Text style={[glSt.text14m, pageorder.ob == item.idx ? glSt.c322A24 : glSt.cC0BCB6]}>{item.str}</Text>
                        </TouchableOpacity>
                        ))}
                        
                    </View>
                </RBSheet> 
                <AlertModal
                    visible={modalVisible}
                    oneButton={false}
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
)(Shoplist);