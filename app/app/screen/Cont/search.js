import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import {  SafeAreaView, View, TouchableOpacity, Dimensions, ScrollView, TextInput, StyleSheet, Alert, ActivityIndicator, Linking, Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import { KeyboardAwareScrollView } from 'react-native-keyboard-aware-scroll-view';


import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";


const Search = (props) => {
    
    const [ search, setSearch] = useState('');
    const [ keyword, setKeyword] = useState('');
    const [ sviewmode, setSviewmode ] = useState(1);

    return (
        <Layout havebottom={false} havetop={true} havnoback={true} havebtn1={false} havebtn2={false} toptext={""} navigation={props.navigation}>
            <View style={[glSt.px24,glSt.pt54]}   >
                <View style={[glSt.flex,glSt.alcenter,glSt.jubetween,{borderBottomColor:"#5E5955",borderBottomWidth:1,marginBottom:verticalScale(30)}]}>
                    <TextInput value={keyword} onChangeText={text => setKeyword(text) } style={[glSt.c322A24,glSt.text18m,{flex:1}]} />
                    <TouchableOpacity onPress={() => setSearch('1')}>
                        <Image source={Images.icon_search} style={{width:horizontalScale(24),height:horizontalScale(24)}} />
                    </TouchableOpacity>
                </View>
                {search == 1 &&
                <>
                <View style={[glSt.h42,glSt.flex,glSt.alcenter]}>
                    <TouchableOpacity onPress={() => setSviewmode(1)} style={[glSt.mr16]}>
                        <Text style={[glSt.mr16,glSt.text12b,sviewmode === 1 ? glSt.c322A24 : glSt.cC0BCB6]}>통합검색</Text>
                    </TouchableOpacity> 
                    <TouchableOpacity onPress={() => setSviewmode(2)} style={[glSt.mr16]}>
                        <Text style={[glSt.mr16,glSt.text12b,sviewmode === 2 ? glSt.c322A24 : glSt.cC0BCB6]}>쇼핑</Text>
                    </TouchableOpacity> 
                    <TouchableOpacity onPress={() => setSviewmode(2)} style={[glSt.mr16]}>
                        <Text style={[glSt.mr16,glSt.text12b,sviewmode === 3 ? glSt.c322A24 : glSt.cC0BCB6]}>콘텐츠</Text>
                    </TouchableOpacity> 
                </View>
                <View style={[glSt.pt54,glSt.alcenter,glSt.jucenter]}>
                    <Text style={[glSt.cC0BCB6,glSt.text14m]}>검색 결과가 없어요.</Text>
                    <Text style={[glSt.cC0BCB6,glSt.text14m]}>다른 키워드로 검색해 보세요.</Text>
                </View>
                </>
                }
            </View>
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
)(Search);