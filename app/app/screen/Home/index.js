import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  View, TouchableOpacity, Dimensions, ActivityIndicator, ImageBackground, ScrollView } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import Carousel from 'react-native-reanimated-carousel';
import LinearGradient from 'react-native-linear-gradient';

import VersionCheck from 'react-native-version-check';
import Modal from "react-native-modal";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import Axios from "../../utils/Axios";
import { horizontalScale, verticalScale } from "../../utils/Scale";


const Home = (props) => {
    
    const [ loading, setLoading ]  = useState(false);
    const [ result, setResult] = useState({});
    const [ nowpage1, setNowpage1 ] = useState(1);
    const [ nowpage2, setNowpage2 ] = useState(1);

    useEffect(() => {
        const fetchAll = async () => {
        try {
            const [
                banner1Res,
                banner2Res,
                journalres,
            ] = await Promise.all([
                new Promise((resolve, reject) => Axios.get('&act=main&han=get_main&main_idx=4', resolve, reject)),
                new Promise((resolve, reject) => Axios.get('&act=main&han=get_main&main_idx=5', resolve, reject)),
                new Promise((resolve, reject) => Axios.get('&act=cont&han=get_journal', resolve, reject)),
            ]);

            console.log(journalres.datas);

            setResult({
                banner1: banner1Res.datas,
                banner2: banner2Res.datas,
                jurnal: journalres.datas
            });

        } catch (e) {
            console.error('API 중 오류 발생:', e);
        } finally {
            setLoading(true);
        }};
        fetchAll();

        
    }, []);


    if(!loading) {
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
    }   else{
        return (
            <Layout havebottom={true} bottomsel={1} havetop={false} navigation={props.navigation}>
                <ScrollView>
                    <View style={{position:"relative"}}>
                        <Carousel
                            loop
                            autoPlay
                            autoPlayInterval={3000}
                            data={result.banner1}
                            width={Dimensions.get("window").width}
                            height={Dimensions.get("window").width*1.3}
                            onSnapToItem={(index) => setNowpage1(index)}
                            renderItem={({ item , index }) => (
                                <ImageBackground source={{uri:item.imgurl}} style={{width:"100%",height:"100%",position:"relative"}} resizeMode="cover">
                                    <LinearGradient colors={['rgba(0, 0, 0, 0.2)', 'rgba(0, 0, 0, 0.2)']} style={{position: 'absolute', top: 0, left: 0, right: 0, bottom: 0}} start={{ x: 0.5, y: 1 }} end={{ x: 0.5, y: 0 }} />
                                    <View style={{position:"absolute",bottom:33,left:30}}>
                                        <View style={{}}>
                                            <Text style={[glSt.text32b,glSt.cFFFFFF]}>{item.text}</Text>
                                        </View>
                                        <View style={[glSt.mb20]}>
                                            <Text style={[glSt.text32b,glSt.cFFFFFF]}>{item.text2}</Text>
                                        </View>
                                        <View style={[]}>
                                            <Text style={[glSt.text18r,glSt.cFFFFFF]}>{item.text3}</Text>
                                        </View>
                                    </View>
                                </ImageBackground>
                            )}
                        />
                        <View style={[{position:"absolute",backgroundColor:"rgba(0,0,0,0.1)",borderRadius:20,bottom:30,right:30},glSt.px12,glSt.py2]}>
                            <Text style={[glSt.cFFFFFF,glSt.text10b]}>{nowpage1 + 1} / {result.banner1.length}</Text>
                        </View>
                    </View>
                    <View style={[glSt.px24,glSt.h54,glSt.showdow1,glSt.alcenter,glSt.flex,glSt.mb36]}>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Journal")} style={[glSt.mr18]}>
                            <Text style={[glSt.text14b,glSt.c6F6963]}>JOURNAL</Text>
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Event")} style={[glSt.mr18]}>
                            <Text style={[glSt.text14b,glSt.c6F6963]}>EVENT</Text>
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Awards")} style={[glSt.mr18]}>
                            <Text style={[glSt.text14b,glSt.c6F6963]}>AWARDS</Text>
                        </TouchableOpacity>
                        <TouchableOpacity onPress={() => props.navigation.navigate("Stores")} style={[glSt.mr18]}>
                            <Text style={[glSt.text14b,glSt.c6F6963]}>STORES</Text>
                        </TouchableOpacity>
                    </View>
                    <View style={[glSt.px24]}>
                
                        <View style={{}}>
                            <View style={{}}>
                                <Text style={[glSt.text14b,glSt.c6F6963]}>브랜드 숍</Text>
                            </View>
                            <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,glSt.py36]}>
                                <TouchableOpacity onPress={() => props.navigation.navigate("Shoplist",{cate:"01"})} style={[glSt.flex,glSt.alcenter,glSt.jucenter]}>
                                    <Image source={Images.main1} style={{width:horizontalScale(80),height:horizontalScale(30)}} resizeMode="contain" />
                                </TouchableOpacity>
                                 <View style={{width:1,height:verticalScale(36),backgroundColor:"#E9E6E0"}}></View>
                                <TouchableOpacity onPress={() => props.navigation.navigate("Shoplist",{cate:"02"})} style={[glSt.flex,glSt.alcenter,glSt.jucenter]}>
                                    <Image source={Images.main2} style={{width:horizontalScale(80),height:horizontalScale(30)}} resizeMode="contain" />
                                </TouchableOpacity>
                                 <View style={{width:1,height:verticalScale(36),backgroundColor:"#E9E6E0"}}></View>
                                <TouchableOpacity onPress={() => props.navigation.navigate("Shoplist",{cate:"03"})} style={[glSt.flex,glSt.alcenter,glSt.jucenter]}>
                                    <Image source={Images.main3} style={{width:horizontalScale(80),height:horizontalScale(30)}} resizeMode="contain" />
                                </TouchableOpacity>
                            </View>
                        </View>
                        <View style={[glSt.mb40]}>
                            <View style={{position:"relative"}}>
                                <Carousel
                                    loop
                                    autoPlay
                                    autoPlayInterval={4000}
                                    data={result.banner2}
                                    width={Dimensions.get("window").width - horizontalScale(48)}
                                    height={verticalScale(100)}
                                    onSnapToItem={(index) => setNowpage2(index)}
                                    renderItem={({ item , index }) => (
                                        <ImageBackground source={{uri:item.imgurl}} style={{width:"100%",height:"100%",position:"relative"}} resizeMode="cover">
                                    
                                        </ImageBackground>
                                    )}
                                />
                                <View style={[{position:"absolute",backgroundColor:"rgba(0,0,0,0.1)",borderRadius:20,bottom:16,right:16},glSt.px12,glSt.py2]}>
                                    <Text style={[glSt.cFFFFFF,glSt.text10b]}>{nowpage2 + 1} / {result.banner2.length}</Text>
                                </View>
                            </View>
                        </View>
                        <View style={[glSt.mb40]}>
                            <View style={[glSt.mb16]}>
                                <Text style={[glSt.text14b,glSt.c6F6963]}>저널</Text>
                            </View>
                            <View>
                                {result.jurnal.map((item,index) => (
                                <TouchableOpacity key={"j"+index} onPress={() => props.navigation.navigate("Journalv",{idx:item.idx})}>
                                    <ImageBackground source={{ uri: item.imgurl }}  style={{width:Dimensions.get("window").width - horizontalScale(48),height:(Dimensions.get("window").width - horizontalScale(48))*1.4,position:"relative",marginBottom:verticalScale(16)}} resizeMode="cover">
                                        <LinearGradient colors={['rgba(0, 0, 0, 0.2)', 'rgba(0, 0, 0, 0.2)']} style={{position: 'absolute', top: 0, left: 0, right: 0, bottom: 0}} start={{ x: 0.5, y: 1 }} end={{ x: 0.5, y: 0 }} />
                                        <View style={{position:"absolute",bottom:verticalScale(30),left:horizontalScale(16),right:horizontalScale(16)}}>
                                            <View style={[]}>
                                                <Text style={[glSt.cFFFFFF,glSt.text12b]}>#{item.catename}</Text>
                                            </View>
                                            <View style={[glSt.mb2]}>
                                                <Text style={[glSt.cFFFFFF,glSt.text16b]}>{item.subject}</Text>
                                            </View>
                                            <View style={[glSt.flex,glSt.alcenter]}>
                                                <Text style={[glSt.cFFFFFF,glSt.text12m]}>{item.wdate.substring(0, 10)} 조회 {item.readcount}</Text>
                                            </View>
                                        </View>
                                    </ImageBackground>
                                </TouchableOpacity>
                                ))}
                            </View>
                        </View>
                    </View>
                </ScrollView>
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
)(Home);