// function setGaugeValue(gauge, value) {
//   if (!gauge) {
//     console.error("Gauge element not found");
//     return;
//   }

//   const constantNumber = 70; // الرقم الثابت لتقسيم القيمة عليه
//   let percentage;

//   // تأكد من أن القيمة ضمن النطاق الصحيح وقم بتقسيمها على الرقم الثابت
//   if (value >= 0 && value <= 70) { 
//     const modifiedValue = value / constantNumber; // تقسيم القيمة على الرقم الثابت
//     percentage = modifiedValue * 100; // حساب النسبة المئوية
//   } else {
//     console.warn("Value out of range");
//     return;
//   }

//   const gaugeFill = gauge.querySelector(".gauge__fill");
//   const gaugeCover = gauge.querySelector(".gauge__cover");

//   if (gaugeFill && gaugeCover) {
//     const rotation = percentage * 1.8; // تحويل النسبة إلى زاوية
//     gaugeFill.style.transform = `rotate(${rotation}deg)`; // دوران المؤشر
//     gaugeCover.textContent = `${Math.round(percentage)}%`; // عرض النسبة المئوية
//   } else {
//     console.error("Gauge fill or cover element not found");
//   }
// }
