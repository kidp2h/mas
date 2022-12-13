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
      result.push(temp);

    }
    if(rule?.min && value.length < rule.min ) {
      let temp = {};
      temp.selector = selector;
      temp.message = MESSAGE.MIN(rule.min)
      result.push(temp);
    }
    if(rule?.max && value.length > rule.max) {
      let temp = {};
      temp.selector = selector;
      temp.message = MESSAGE.MAX(rule.max)
      result.push(temp);
    }
    const messageSelector = `span[message='${selector.slice(1)}']`
    $(messageSelector).classList.remove("active")
    $(`${selector}`).classList.remove("error")
  });
  if(result.length === 0 ) return true;

  result?.forEach(item => {
    if ($(`${item.selector}`) && $(`span[message='${item.selector.slice(1)}']`)) {
      $(`span[message='${item.selector.slice(1)}']`).innerText = item.message
      $(`span[message='${item.selector.slice(1)}']`)?.classList.add("active")
      $(`${item.selector}`).classList.add("error")
    }
  })
  return result;

}