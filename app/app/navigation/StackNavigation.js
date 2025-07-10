import React from 'react';
import { createStackNavigator } from '@react-navigation/stack';


// Pages For App 
import Loading from "../screen/Loading";
import Home from "../screen/Home/index.js";

import Login from "../screen/Member/login.js"
import Joinstep1 from "../screen/Member/joinstep1.js"
import Joinstep2 from "../screen/Member/joinstep2.js"
import Joinstep3 from "../screen/Member/joinstep3.js"
import Joinstep4 from "../screen/Member/joinstep4.js"
import Findid from "../screen/Member/findid.js"
import Findidshow from "../screen/Member/findidshow.js"
import Findpasswd from "../screen/Member/findpasswd.js"
import Findpasswdshow from "../screen/Member/findpasswdshow.js"
import Journal from "../screen/Cont/journal.js"
import Journalv from "../screen/Cont/journalv.js"
import Event from "../screen/Cont/event.js"
import Eventv from "../screen/Cont/eventv.js"
import Awards from "../screen/Cont/awards.js"
import Stores from "../screen/Cont/stores.js"
import Guide from "../screen/Cont/guide.js"
import Guideresult from "../screen/Cont/guideresult.js"

import Shoplist from "../screen/Shop/list.js"
import Shopview from "../screen/Shop/view.js"

import Mymain from "../screen/Mypage/main.js"
import Wish from "../screen/Mypage/wish.js"
import Coupon from "../screen/Mypage/coupon.js"
import Couponregi from "../screen/Mypage/couponregi.js"
import Point from "../screen/Mypage/point.js"
import Attendance from "../screen/Mypage/attendance.js"
import Gift1 from "../screen/Mypage/gift1.js"
import Gift2 from "../screen/Mypage/gift2.js"
import Orders from "../screen/Mypage/orders.js"
import Orderview from "../screen/Mypage/orderview.js"
import Recent from "../screen/Mypage/recent.js"
import Cancels from "../screen/Mypage/cancels.js"
import Myinfo from "../screen/Mypage/myinfo.js"
import Myinfoview from "../screen/Mypage/myinfoview.js"
import Center from "../screen/Mypage/canter.js"
import Config from "../screen/Mypage/config.js"
import Alarm from "../screen/Mypage/alarm.js"
import Cart from "../screen/Order/cart.js"
import Search from "../screen/Cont/search.js"
import Gradeinfo from "../screen/Cont/gradeinfo.js"
import Chpasswd from "../screen/Mypage/chpasswd.js"

import Faq from "../screen/Center/faq.js"
import Request from "../screen/Center/request.js"
import Yak from "../screen/Center/yak.js"
import Alarmconfig from "../screen/Mypage/alarmconfig.js"
import Lang from "../screen/Mypage/lang.js"

import Orderstep2 from "../screen/Order/orderstep2.js"
import Orderstep2g from "../screen/Order/orderstep2g.js"

const Stack = createStackNavigator();

export default function StackNavigation() {


    
    return (
            <Stack.Navigator
			    initialRouteName="Loading"
                screenOptions={{ headerShown: false }}>
                
                <Stack.Screen name="Loading" component={Loading} options={{gestureEnabled: false}} />
                <Stack.Screen name="Home" component={Home} />
                <Stack.Screen name="Mymain" component={Mymain} />
                <Stack.Screen name="Wish" component={Wish} />
                <Stack.Screen name="Coupon" component={Coupon} />
                <Stack.Screen name="Couponregi" component={Couponregi} />
                <Stack.Screen name="Attendance" component={Attendance} />
                <Stack.Screen name="Point" component={Point} />
                <Stack.Screen name="Gift1" component={Gift1} />
                <Stack.Screen name="Gift2" component={Gift2} />
                <Stack.Screen name="Orders" component={Orders} />
                <Stack.Screen name="Orderview" component={Orderview} />
                <Stack.Screen name="Recent" component={Recent} />
                <Stack.Screen name="Cancels" component={Cancels} />
                <Stack.Screen name="Myinfo" component={Myinfo} />
                <Stack.Screen name="Myinfoview" component={Myinfoview} />
                <Stack.Screen name="Center" component={Center} />
                <Stack.Screen name="Config" component={Config} />
                <Stack.Screen name="Alarm" component={Alarm} />
                <Stack.Screen name="Cart" component={Cart} />
                <Stack.Screen name="Orderstep2" component={Orderstep2} />
                <Stack.Screen name="Orderstep2g" component={Orderstep2g} />
                <Stack.Screen name="Login" component={Login} />
                <Stack.Screen name="Search" component={Search} />
                <Stack.Screen name="Joinstep1" component={Joinstep1} />
                <Stack.Screen name="Joinstep2" component={Joinstep2} />
                <Stack.Screen name="Joinstep3" component={Joinstep3} />
                <Stack.Screen name="Joinstep4" component={Joinstep4} />
                <Stack.Screen name="Findid" component={Findid} />
                <Stack.Screen name="Findidshow" component={Findidshow} />
                <Stack.Screen name="Findpasswd" component={Findpasswd} />
                <Stack.Screen name="Findpasswdshow" component={Findpasswdshow} />
                <Stack.Screen name="Journal" component={Journal} />
                <Stack.Screen name="Journalv" component={Journalv} />
                <Stack.Screen name="Event" component={Event} />
                <Stack.Screen name="Eventv" component={Eventv} />
                <Stack.Screen name="Awards" component={Awards} />
                <Stack.Screen name="Stores" component={Stores} />
                <Stack.Screen name="Guide" component={Guide} />
                <Stack.Screen name="Guideresult" component={Guideresult} />
                <Stack.Screen name="Shoplist" component={Shoplist} />
                <Stack.Screen name="Shopview" component={Shopview} />
                <Stack.Screen name="Gradeinfo" component={Gradeinfo} />
                <Stack.Screen name="Chpasswd" component={Chpasswd} />
                <Stack.Screen name="Request" component={Request} />
                <Stack.Screen name="Faq" component={Faq} />
                <Stack.Screen name="Yak" component={Yak} />
                <Stack.Screen name="Alarmconfig" component={Alarmconfig} />
                <Stack.Screen name="Lang" component={Lang} />
            </Stack.Navigator>
    );
}