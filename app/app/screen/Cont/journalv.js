import React, { useState, useEffect, useCallback  } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import { View, TouchableOpacity, Dimensions, Share, ImageBackground, ActivityIndicator, TouchableWithoutFeedback , Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import { useFocusEffect } from '@react-navigation/native';
import LinearGradient from 'react-native-linear-gradient';
import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";

import RenderHTML from 'react-native-render-html';
import Animated, {
    useSharedValue,
    useAnimatedScrollHandler,
    useAnimatedStyle,
    interpolate,
    Extrapolate
} from 'react-native-reanimated';
import { horizontalScale, verticalScale } from "../../utils/Scale";

const Journalv = (props) => {

    const [loading, setLoading] = useState(false);
    const [data, setData] = useState('');
    const [idx, setIdx] = useState(0);
    const [htmlContent, setHtmlContent] = useState('');
    const [imageHeight, setImageHeight] = useState(300); // 초기 이미지 높이 예측값

    const scrollY = useSharedValue(0);

    const scrollHandler = useAnimatedScrollHandler({
        onScroll: (event) => {
            scrollY.value = event.contentOffset.y;
        },
    });

    const animatedStyle = useAnimatedStyle(() => {
        const opacity = interpolate(
            scrollY.value,
            [0, imageHeight - 80], // 이미지가 사라질 때쯤 불투명하게
            [0, 1],
            Extrapolate.CLAMP
        );
        return {
            backgroundColor: `rgba(253, 251, 245,${opacity})`,
        };
    });

    useFocusEffect(
        React.useCallback(() => {
            if (props.route.params?.idx) {
                setIdx(props.route.params.idx);
            }
        }, [props.route.params])
    );

    useEffect(() => {
        if (idx !== 0) {
            get_event();
        }
    }, [idx]);

    async function get_event() {
        setLoading(false);
        await Axios.get('&act=cont&han=get_journalv&idx=' + idx,
            (response) => {
                setData(response.datas);
                setHtmlContent(response.datas.memo);
                setTimeout(() => {
                    setLoading(true);
                }, 500);
            },
            (error) => console.log(error)
        );
    }

    const onShare = async () => {
        try {
            const result = await Share.share({
                title: data.subject,
                message: '',
                url: 'http://www.granhand.kro.kr/cont/?act=journalv&idx='+data.idx // iOS에서 message 대신 url을 사용할 수 있음
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

    if (loading) {
        return (
            <Layout havebottom={false} havetop={false} havnoback={true} haveshare={true} toptext={"JOURNAL"} navigation={props.navigation}>
                <Animated.View style={[{
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    right: 0,
                    zIndex: 10,
                    padding: 0
                }, animatedStyle]}>
                    <View style={[glSt.h58, glSt.px24, glSt.flex, glSt.alcenter, glSt.jubetween]}>
                        <View style={[glSt.flex, glSt.alcenter]}>
                            <TouchableOpacity onPress={() => props.navigation.goBack()} style={[glSt.mr24]}>
                                <Image source={Images.icon_back} style={{ width: horizontalScale(24), height: horizontalScale(24) }} />
                            </TouchableOpacity>
                            <Text style={[glSt.text18b,glSt.c322A24]}>JOURNAL</Text>
                        </View>
                        <View style={[glSt.flex, glSt.alcenter]}>
                            <TouchableOpacity onPress={() => onShare()}>
                                <Image source={Images.icon_share} style={{ width: horizontalScale(24), height: horizontalScale(24) }} />
                            </TouchableOpacity>
                        </View>
                    </View>
                </Animated.View>

                <Animated.ScrollView
                    onScroll={scrollHandler}
                    scrollEventThrottle={16}
                >
                    <View style={[glSt.mb32]}>
                        <ImageBackground  source={{ uri: data.imgurl }}  style={{width:Dimensions.get("window").width,height:(Dimensions.get("window").width - horizontalScale(48))*1.4,position:"relative",marginBottom:verticalScale(16)}} resizeMode="cover">
                                <LinearGradient colors={['rgba(0, 0, 0, 0.2)', 'rgba(0, 0, 0, 0.2)']} style={{position: 'absolute', top: 0, left: 0, right: 0, bottom: 0}} start={{ x: 0.5, y: 1 }} end={{ x: 0.5, y: 0 }} />
                                <View style={{position:"absolute",bottom:verticalScale(30),left:horizontalScale(16),right:horizontalScale(16)}}>
                                    <View style={[]}>
                                        <Text style={[glSt.cFFFFFF,glSt.text12b]}>#{data.catename}</Text>
                                    </View>
                                    <View style={[glSt.mb2]}>
                                        <Text style={[glSt.cFFFFFF,glSt.text16b]}>{data.subject}</Text>
                                    </View>
                                    <View style={[glSt.flex,glSt.alcenter]}>
                                        <Text style={[glSt.cFFFFFF,glSt.text12m]}>{data.wdate.substring(0, 10)} 조회 {data.readcount}</Text>
                                    </View>
                                </View>
                        </ImageBackground>
                    </View>
                    <View style={[glSt.px24]}>
                        <RenderHTML
                            contentWidth={Dimensions.get('window').width - horizontalScale(48)}
                            source={{ html: htmlContent }}
                        />
                        <View style={{ height: 60 }} />
                    </View>
                </Animated.ScrollView>
            </Layout>
        );
    } else {
        return (
            <Layout havebottom={false} havetop={false} navigation={props.navigation}>
                <View style={{ flex: 1, justifyContent: "center", alignItems: "center" }} >
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
        baseData: state.auth
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
)(Journalv);
