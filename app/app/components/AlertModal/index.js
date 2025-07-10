// components/AlertModal.js
import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet, Dimensions } from 'react-native';
import Modal from 'react-native-modal';
import { horizontalPercentageScale, horizontalScale, verticalScale } from '../../utils/Scale';
import glSt from '../../assets/styles/glSt';

const AlertModal = ({
    visible,
    title = '알림',
    message,
    oneButton = false,
    confirmText = '확인',
    cancelText = '취소',
    onConfirm = () => {},
    onCancel = () => {},
    onClose = () => {},
    }) => {
        
    const handleConfirm = () => {
        onConfirm();
        onClose();
    };

    const handleCancel = () => {
        onCancel();
        onClose();
    };

    return (
        <Modal isVisible={visible} onBackdropPress={onClose}>
            <View style={{backgroundColor:"#FFFFFF"}}>
                <View style={{paddingTop:verticalScale(20),paddingHorizontal:horizontalScale(45),alignItems: 'center'}}>
                    <Text style={[glSt.c322A24,glSt.text16b]}>{title}</Text>
                    <View style={[glSt.mb14]}>
                        <Text style={[glSt.text12m,glSt.cC0BCB6]}>{message}</Text>
                    </View>
                </View>
                <View style={[{borderTopColor:"rgba(0,0,0,0.08)",borderTopWidth:1},glSt.flex,glSt.alcenter,glSt.jucenter]}>
                    {oneButton ? (
                    <TouchableOpacity style={{paddingVertical:verticalScale(12)}} onPress={handleCancel}>
                        <Text style={[glSt.text16r,glSt.c6F6963]}>{cancelText}</Text>
                    </TouchableOpacity>
                    ) : (
                    <>
                        
                        <TouchableOpacity style={[{paddingVertical:verticalScale(12),flex:1,borderRightColor:"rgba(0,0,0,0.08)",borderRightWidth:1},glSt.alcenter,glSt.jucenter]} onPress={handleConfirm}>
                            <Text style={[glSt.text16r,glSt.c6F6963]}>{confirmText}</Text>
                        </TouchableOpacity>
                        <TouchableOpacity style={[{paddingVertical:verticalScale(12),flex:1},glSt.alcenter,glSt.jucenter]} onPress={handleCancel}>
                            <Text style={[glSt.text16r,glSt.c6F6963]}>{cancelText}</Text>
                        </TouchableOpacity>
                    </>
                    )}
                </View>
            </View>
        </Modal>
    );
};

export default AlertModal;

