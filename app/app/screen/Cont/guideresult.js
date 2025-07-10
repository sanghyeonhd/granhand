import React, { useState, useEffect, useCallback  } from "react";
import { connect } from "react-redux";
import { AuthActions } from "../../actions/index";
import { View, TouchableOpacity, Dimensions, ScrollView, ImageBackground, ActivityIndicator, TouchableWithoutFeedback , Platform } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config/index";
import { Image, Text } from "../../components/index";
import { useFocusEffect } from '@react-navigation/native';
import LinearGradient from 'react-native-linear-gradient';

import Axios from "../../utils/Axios";
import Layout from "../../components/Layouts/Layout";
import glSt from "../../assets/styles/glSt";
import { horizontalScale, verticalScale } from "../../utils/Scale";


const Guideresult = (props) => {

    const [ loading, setLoading ]  = useState(true);

    
    
    if(loading) {
        return (
            <Layout havebottom={false} havetop={true} havnoback={true} toptext={"GUIDE"} navigation={props.navigation}>
                
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
)(Guideresult);