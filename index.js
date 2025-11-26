const arr = [2, 3, 4]

const [x, y, z] = arr

console.log(x, y, z);
console.log(...arr);

const obj = {
    name: 'abc',
    email: 'abc@gmail.com'
}

const newObj =  {...obj}

console.log(newObj);

const arr2 = [1, 2, ...[3, 4]]

for(i=0; i<arr2.length;i++){
    // console.log(arr2[i]);
}

for(const num of arr2){
    // console.log(num);
}

for(const num of arr2.entries()){
    console.log(num);
}


let age = 18
console.log(18<=age? 'adult':'minor');