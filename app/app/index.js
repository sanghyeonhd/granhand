import React, { useState, useEffect } from 'react';
import { store, persistor } from "./store";
import { StatusBar,ToastAndroid, BackHandler, Alert, View, Text, TouchableOpacity } from "react-native";
import { BaseColor, BaseSetting } from "./config/";
import { Provider } from "react-redux";
import { NavigationContainer, useNavigation } from '@react-navigation/native';
import { PersistGate } from "redux-persist/integration/react";
import StackNavigation from './navigation/StackNavigation';
import { scaleFontSize, verticalScale } from './utils/Scale';



export default function index(props) {

    const [isModal, setIsModal] = useState(false);
    const [msgdata, setMsgdata]  = useState({title:"",memo:"",link:""})

    

    return (
        <>
            <StatusBar 
                barStyle="dark-content" // 글자색: 어두운 색 (흰 배경에 잘 보임)
                backgroundColor="transparent" // 안드로이드 배경 투명
                translucent={true} // 상태바 위로 콘텐츠가 깔리도록
            />
            <Provider store={store}>
            <PersistGate loading={null} persistor={persistor}>
                <NavigationContainer>
                    <StackNavigation />
                </NavigationContainer>
            </PersistGate>
        </Provider>
        </>
        
    );
}