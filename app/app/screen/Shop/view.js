import React, { useState, useEffect, useRef } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  View, TouchableOpacity, Dimensions, ScrollView, StyleSheet, Share, ActivityIndicator, Platform, ImageBackground } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text, AutoSizeRemoteImage } from "../../components/index";
import { useFocusEffect } from '@react-navigation/native';
import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";
import RBSheet from 'react-native-raw-bottom-sheet';
import Carousel from 'react-native-reanimated-carousel';
import LinearGradient from 'react-native-linear-gradient';
import Animated, { useSharedValue,useAnimatedScrollHandler,useAnimatedStyle,interpolate,} from 'react-native-reanimated';
import AlertModal from "../../components/AlertModal";

const Shopview = (props) => {
    
    const refRBSheet1 = useRef();

    const [ nowpage1, setNowpage1 ] = useState(1);
    const [ loading, setLoading ] = useState(false);
    const [ idx, setIdx ]  = useState(0);

    const [ modalVisible , setModalVisible ] = useState(false);
    const [ showmsg , setShowmsg ] = useState({
        title:"",
        message:"",
        confirmText:"",
        cancelText:"",
        movetype:0
    })


    const [ ea, setEa ]  = useState(1);
    const [ mode, setMode ]  = useState(1);

    const [ datas, setDatas ] = useState('');
    const [ htmlContent, setHtmlContent ] = useState('');
    const carouselHeight = Dimensions.get("window").width * 1.3;

   const scrollY = useSharedValue(0);

    const scrollHandler = useAnimatedScrollHandler({
        onScroll: (event) => {
            scrollY.value = event.contentOffset.y;
        },
    });

    const animatedStyle = useAnimatedStyle(() => {
        const bgColor = interpolate(
            scrollY.value,
            [0, carouselHeight],
            [0, 1]
        );
        return {
            backgroundColor: `rgba(253, 251, 245,${bgColor})`,
        };
    });

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
            get_goods()
        }
    },[idx]);

    async function get_goods() {
        setLoading(false);
        await Axios.get('&act=goods&han=get_view&idx='+idx+'&mem_idx='+props.baseData.userData.idx,
            (response) => {
                setDatas(response.datas);
                console.log(response.datas);
                setHtmlContent(response.datas.goods.memo);
                setTimeout(() => {
                        setLoading(true);
                }, 500); // 10000ms = 10초
            },
            (error) => console.log(error)
        );
    }

    function openac(m)  {
        setMode(m)
        refRBSheet1.current.open()
    }

    async function go_cart(m){
        if(props.baseData.isLogin)  {

            await Axios.get('&act=order&han=set_cart&idx='+idx+'&mem_idx='+props.baseData.userData.idx+"&ea="+ea,
                (response) => {
                    if(m == 1){
                         setShowmsg({title:"잠바구니에 삼품을 담았습니다.",
                            message:"장바구니로 이동하시겠습니까?",
                            confirmText:"장바구니이동",
                            cancelText:"닫기",movetype:2})
                        setModalVisible(true);
                    }
                    if(m == 2)  {
                        props.navigation.navigate("Orderstep2",{goods:[{idx:response.idx}]});
                    }
                    if(m == 3)  {
                        props.navigation.navigate("Orderstep2g",{goods:[{idx:response.idx}]});
                    }
                },
                (error) => console.log(error)
            );


        }   else    {
            setShowmsg({title:"로그인이 필요합니다.",
                message:"로그인 하시겠습니다?",
                confirmText:"로그인",
                cancelText:"닫기",movetype:1})
            setModalVisible(true);
        }
    }

    function profunc()  {
        setModalVisible(false);
        if(showmsg.movetype == 1)   {
            props.navigation.navigate("Login")
        }
        if(showmsg.movetype == 2)   {
            props.navigation.navigate("Cart")
        }
    }

    async function set_wish(idx) {

        if(props.baseData.isLogin){
            await Axios.get('&act=goods&han=set_wish&goods_idx='+idx+"&mem_idx="+props.baseData.userData.idx,
            (response) => {
                if(response.res == 'ok1')   {
                    setDatas(prev => ({
                        ...prev,
                        goods: {
                        ...prev.goods,
                        havewish: 'Y'
                        }
                    }));
                }   else    {
                    setDatas(prev => ({
                        ...prev,
                        goods: {
                        ...prev.goods,
                        havewish: 'N'
                        }
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

    const onShare = async () => {
            try {
                const result = await Share.share({
                    title: datas.gname,
                    message: '',
                    url: 'http://www.granhand.kro.krr/shop/?act=view&idx='+idx // iOS에서 message 대신 url을 사용할 수 있음
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
            <Layout havebottom={false} havetop={false} havnoback={false} toptext={""} navigation={props.navigation}>
                <Animated.View style={[{ 
                    position: 'absolute', 
                    top: 0, 
                    left: 0, 
                    right: 0, 
                    zIndex: 10, 
                    padding: 0 
                }, animatedStyle]}>
                    <View style={[glSt.h58,glSt.px24,glSt.flex,glSt.alcenter,glSt.jubetween]}>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <TouchableOpacity onPress={() => props.navigation.goBack()} style={[glSt.mr24]}>
                                <Image source={Images.icon_back} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                            </TouchableOpacity>
                        </View>
                        <View style={[glSt.flex,glSt.alcenter]}>
                            <TouchableOpacity onPress={() => onShare()} style={[glSt.mr20]}>
                                <Image source={Images.icon_share} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                            </TouchableOpacity>
                            <TouchableOpacity onPress={() => set_wish(datas.goods.idx)} style={[glSt.mr20]}>
                                <Image source={datas.goods.havewish == 'Y' ? Images.icon_heartg_on : Images.icon_heart} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                            </TouchableOpacity>
                             <TouchableOpacity onPress={() => props.navigation.navigate("Cart")}>
                                <Image source={Images.icon_cart} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                            </TouchableOpacity>
                        </View>
                    </View>
                </Animated.View>
                <Animated.ScrollView 
                    onScroll={scrollHandler}
                    scrollEventThrottle={16}
                >
                    <View style={{ height: carouselHeight }}>
                        <Carousel
                            loop
                            autoPlay
                            autoPlayInterval={3000}
                            data={datas.imglist}
                            width={Dimensions.get("window").width}
                            height={carouselHeight}
                            onSnapToItem={(index) => setNowpage1(index)}
                            renderItem={({ item, index }) => (
                                <ImageBackground
                                    source={{ uri: item.imgurl }}
                                    style={{ width: "100%", height: "100%", position: "relative" }}
                                    resizeMode="cover"
                                >
                
                                </ImageBackground>
                            )}
                        />

                        <View style={{position: "absolute",backgroundColor: "rgba(0,0,0,0.1)",borderRadius: 20,bottom: 30,right: 30,paddingHorizontal: 12,paddingVertical: 4}}>
                            <Text style={{ color: "#FFF", fontSize: 10, fontWeight: "bold" }}>
                                {nowpage1 + 1} / {datas.imglist.length}
                            </Text>
                        </View>
                    </View>
                    <View style={[glSt.px24,glSt.pt24]}>
                        <View style={[glSt.flex,glSt.alcenter,glSt.mb4]}>
                            {datas.catelist.map((item,index) => (
                            <>
                            {index !=0 &&
                            <Text style={[glSt.c322A24,glSt.text12r]} key={"cate1"+index}> &gt; </Text>
                            }
                            <Text style={[glSt.c322A24,glSt.text12r]} key={"cate2"+index}>{item.catename}</Text>
                            
                            </>
                            ))}
                            
                        </View>
                        <View style={[glSt.mb4]}>
                            <Text style={[glSt.text18b,glSt.c000000]}>{datas.goods.gname}</Text>
                        </View>
                         <View style={[glSt.mb4]}>
                            <Text style={[glSt.text12r,glSt.cC0BCB6]}>{datas.goods.gname_pre}</Text>
                        </View>
                         <View style={[glSt.mb24]}>
                            <Text style={[glSt.text12r,glSt.c322A24]}>{datas.goods.account} KRW</Text>
                        </View>
                        <View style={[glSt.mb24]}>
                            <Text style={[glSt.c6F6963,glSt.text14b]}>Fragrance Story</Text>
                        </View>
                        <View style={{marginBottom:verticalScale(100)}}>

                        </View>
                        <View style={[glSt.mb24]}>
                            <Text style={[glSt.c6F6963,glSt.text14b]}>Information</Text>
                        </View>
                        <View style={{marginBottom:verticalScale(40)}}>

                        </View>
                        <View style={[glSt.mb24]}>
                            <Text style={[glSt.c6F6963,glSt.text14b]}>Recommend</Text>
                        </View>
                    </View>
                </Animated.ScrollView >
                <View style={[glSt.px24,glSt.py24,glSt.flex,glSt.alcenter]}>
                    <TouchableOpacity onPress={() => openac(1)} style={[{flex:1},glSt.borderC0BCB6,glSt.h46,glSt.alcenter,glSt.jucenter]}>
                        <Text style={[glSt.c322A24,glSt.text14b]}>선물하기</Text>
                    </TouchableOpacity>
                    <View style={{width:horizontalScale(16)}}></View>
                    <TouchableOpacity onPress={() => openac(2)} style={[{flex:1},glSt.bg322A24,glSt.border322A24,glSt.h46,glSt.alcenter,glSt.jucenter]}>
                        <Text style={[glSt.cFDFBF5,glSt.text14b]}>구매하기</Text>
                    </TouchableOpacity>
                </View>
                <RBSheet
                    ref={refRBSheet1}
                >
                    <View style={[glSt.bgFDFBF5,[glSt.px24,glSt.pt24,{height:"100%"}]]}>
                        <View style={{marginBottom:verticalScale(16),backgroundColor: '#FDFBF5',shadowColor: 'rgba(50, 42, 36, 0.7)',shadowOffset: {width: 0,height: 0,},shadowOpacity: 1,shadowRadius: 10,elevation: 3,}}>
                            <View style={[glSt.px16,glSt.py16]}>
                                <View style={[glSt.mb4]}>
                                    <Text style={[glSt.c322A24,glSt.text12b]}>{datas.goods.gname}</Text>
                                </View>
                                <View style={[glSt.mb4]}>
                                    <Text style={[glSt.cC0BCB6,glSt.text12b]}>{datas.goods.gname_pre}</Text>
                                </View>
                                <View style={[glSt.flex,glSt.alcenter,glSt.jubetween]}>
                                    <Text style={[glSt.c322A24,glSt.text12b]}>{datas.goods.account}원</Text>
                                    <View style={[glSt.flex,glSt.alcenter]}>
                                        <TouchableOpacity onPress={() => ea != 1 && setEa(ea - 1) }>
                                            <Image source={Images.icon_minus}  style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                                        </TouchableOpacity>
                                        <Text style={[glSt.px2,glSt.text12b,glSt.c322A24]}>
                                            {ea} 
                                        </Text>
                                        <TouchableOpacity onPress={() => setEa(ea + 1) }>
                                            <Image source={Images.icon_plus}  style={{width:horizontalScale(24),height:horizontalScale(24)}}  />
                                        </TouchableOpacity>
                                    </View>
                                </View>
                                
                            </View>
                        </View>
                        {mode == 1 ?
                        <View style={[glSt.flex,glSt.alcenter,{position:"absolute",bottom:verticalScale(24),left:horizontalScale(24),right:horizontalScale(24)}]}>
                            <TouchableOpacity onPress={() => go_cart(3)} style={[{flex:1},glSt.bg322A24,glSt.border322A24,glSt.h46,glSt.alcenter,glSt.jucenter]}>
                                <Text style={[glSt.cFDFBF5,glSt.text14b]}>선물하기</Text>
                            </TouchableOpacity>
                        </View>
                        :
                        <View  style={[glSt.flex,glSt.alcenter,{position:"absolute",bottom:verticalScale(24),left:horizontalScale(24),right:horizontalScale(24)}]}>
                            <TouchableOpacity onPress={() => go_cart(1)} style={[{flex:1},glSt.borderC0BCB6,glSt.h46,glSt.alcenter,glSt.jucenter]}>
                                <Text style={[glSt.c322A24,glSt.text14b]}>장바구니담기</Text>
                            </TouchableOpacity>
                            <View style={{width:horizontalScale(16)}}></View>
                            <TouchableOpacity onPress={() => go_cart(2)} style={[{flex:1},glSt.bg322A24,glSt.border322A24,glSt.h46,glSt.alcenter,glSt.jucenter]}>
                                <Text style={[glSt.cFDFBF5,glSt.text14b]}>구매하기</Text>
                            </TouchableOpacity>
                        </View>
                        }
                        
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
)(Shopview);