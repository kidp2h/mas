const $ = (selector) => document.querySelector(selector)
const $$ = (selector) => document.querySelectorAll(selector)
const BASE_URL = "http://localhost:80"

const MESSAGE = {
  REQUIRED: "This field can not be empty",
  MIN: value => `Min length of this field must be ${value}`,
  MAX: value => `Max length of this field must be ${value}`
  
}


const validator = (rules) => {
  let result = [];
  rules.forEach(rule => {
    const {selector} = rule;
    const value = $(`${selector}`).value;
    if(rule?.required && (value === "" || value === undefined || value === null)){
      let temp = {};
      temp.selector = selector;
      temp.message = MESSAGE.REQUIRED;
      console.log(selector,"required: ", rule.required,temp.message);
      result.push(temp);

    }
    if(rule?.min && value.length < rule.min ) {
      let temp = {};
      temp.selector = selector;
      temp.message = MESSAGE.MIN(rule.min)
      console.log(selector,"min: ",  rule.min,temp.message);
      result.push(temp);
    }
    if(rule?.max && value.length > rule.max) {
      let temp = {};
      temp.selector = selector;
      temp.message = MESSAGE.MAX(rule.max)
      console.log(selector,"max: ", rule.max, temp.message);
      result.push(temp);
    }
  });
  console.log(result);
  if(result.length === 0 ) return true;
  return result;

}