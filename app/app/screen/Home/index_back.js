import React, { useState, useEffect, useRef } from "react";
import { View, BackHandler , ActivityIndicator,Linking, Platform, Share, StyleSheet, Modal, TouchableOpacity } from "react-native";
import { Images, BaseColor, BaseSetting } from "../../config";
import {SafeAreaView, SafeAreaProvider} from 'react-native-safe-area-context';
import { WebView } from "react-native-webview";
import {
  Camera,
  useCameraDevices,
  useCodeScanner,
  getCameraDevice,
} from "react-native-vision-camera";



export default Home = ({ navigation }) => {

    const webView = useRef(); 
   

    const [ weburl, setWeburl ] = useState('http://mgranhand.kro.kr/?isapp=Y');
    const [ canGoBack, setCanGoBack] = useState(false);
    const [ cords, setCords] = useState('');

     const devices = useCameraDevices();
    const device = getCameraDevice(devices, "back");  
    const [modalVisible, setModalVisible] = useState(false);
    const [isScanning, setIsScanning] = useState(true);
    
    
    const codeScanner = useCodeScanner({
        codeTypes: ['ean-13'],
        onCodeScanned: (codes) => {
            for (const code of codes) {
                setIsScanning(false)
                console.log(`Code Value: ${code.value}`);
                setModalVisible(false);  
            }
        },
    });

    function displaySpinner() {
        return (
            <ActivityIndicator
                color = {BaseColor.primaryColor}
                size = "large"
            />
        );
    }

    const onShouldStartLoadWithRequest = (event) => {
        if (event.url.startsWith('http://') || event.url.startsWith('https://') || event.url.startsWith('about:blank')) {
            return true;
        }
        if (event.url.startsWith('sms:')) {
            Linking.openURL(event.url);
            return false;
        }

          if (Platform.OS === 'android') {
            SendIntentAndroid.openAppWithUri(event.url)
              .then(isOpened => {
                if (!isOpened) {
                  alert('앱 실행에 실패했습니다');
                }
              })
              .catch(err => {
                console.log(err);
              });
          } else {
            Linking.openURL(event.url).catch(err => {
              alert(
                '앱 실행에 실패했습니다. 설치가 되어있지 않은 경우 설치하기 버튼을 눌러주세요.',
              );
            });
            return false;
          }
      };

      const handleOnMessage = (e) => {
        console.log("========================ddd");
        var data = e.nativeEvent.data;
        data = JSON.parse(data);
        //alert(data.type);

        if (data.type === "showcamera") {
            setModalVisible(true);
        }
    }


    
    if(weburl=='')   {
        return (
            <SafeAreaProvider>
                <SafeAreaView style={{flex:1,backgroundColor:"#FFFFFF"}}>
                    <View style={{flex:1,backgroundColor:"#FFFFFF",justifyContent:"center"}}>
                        <ActivityIndicator
                            size="small"
                            color={BaseColor.primaryColor}
                            style={{
                                justifyContent: "center",
                                alignItems: "center"
                            }}
                        
                        />
                    </View>
                </SafeAreaView>
           </SafeAreaProvider>
        );

    }
    else{
        return (
            <SafeAreaProvider>
                <SafeAreaView style={{flex:1,backgroundColor:"#FFFFFF"}}>
                    <View style={{flex:1,backgroundColor:"#FFFFFF"}}>
                        <WebView
                        ref={webView}
                        source={{uri:weburl}}
                        cacheEnabled={false}
                        originWhitelist={['*']}
                        javaScriptEnabled={true}
                        textZoom={100}
                        onMessage={handleOnMessage}
                        onShouldStartLoadWithRequest={event => {
                            return onShouldStartLoadWithRequest(event);
                        }}
                        renderLoading={() => {
                            return displaySpinner();
                        }}
                        onNavigationStateChange={(navState) => {
                            console.log(navState);
                            setCanGoBack(navState.canGoBack);
                        }}>
                       </WebView>    
                    </View>
                    <Modal
                        visible={modalVisible}
                        transparent={false}
                        animationType="slide"
                        onRequestClose={() => setModalVisible(false)}
                    >
                        <Camera
                            style={StyleSheet.absoluteFill}
                            device={device}
                            isActive={true}
                            frameProcessorFps={2}
                            codeScanner={codeScanner}
                        />
                    </Modal>
                </SafeAreaView>
           </SafeAreaProvider>
        );
    }
    
};
const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    paddingHorizontal: 20,
  },
  button: {
    backgroundColor: '#322A24',
    padding: 14,
    borderRadius: 10,
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
  },
  closeButton: {
    padding: 14,
    backgroundColor: '#ccc',
    alignItems: 'center',
  },
  closeText: {
    fontSize: 16,
    color: '#000',
  },
});