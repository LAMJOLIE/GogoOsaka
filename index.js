window.addEventListener("scroll",function(){
    var header = document.querySelector("header");
    header.classList.toggle("sticky", window.scrollY > 0);
})

const popup= document.querySelector('.full-screen');
// console.log(popup);

function togglePopup(){
    popup.classList.toggle('hidden');
}

let result = "";

document.querySelector("#flashButton").addEventListener('click', (e) => {
    togglePopup();
    if(!popup.classList.contains("hidden")){
        // const imageArea = document.getElementById('imageArea');
        const imgList = document.querySelectorAll(".animation-image");
        const resultMsg = document.querySelector("#resultMsg");
        const resultBtn = document.querySelector("#resultBtn");
        console.log(imgList);
        let rand = Math.floor(Math.random() * imgList.length);
        console.log(rand);
        console.log(imgList[rand]);
        let count = 1;
        imgList.forEach((element) => {
            element.classList.add('fade-image' + count);
            count++;
        });
        // imageArea.src = imgList[rand];
        imgList[rand].classList.add('result');
        resultMsg.classList.add('result');
        resultBtn.classList.add('result');
        result = imgList[rand].id;
        console.log(result);
    }
});

document.querySelector("#resultBtn").addEventListener('click', (e) => {
    location.href = "Detail.php?spot_id=" + result;
});