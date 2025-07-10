import * as actionTypes from "./actionTypes";

export function login(idx){
  return {
    type: actionTypes.SETLOGIN,
	  payload: idx
  };
}
export function logout(idx) {
  return {
    type: actionTypes.SETLOGOUT,
	  payload: idx
  };
}