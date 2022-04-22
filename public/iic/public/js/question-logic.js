function add_and_sub(){
      $('#totalNoOfDigitsContainer').hide();
      $('.tie_div').hide();
      var maxNumberOfDigits;
      var maxNumberOfRows;
      var digitsMapping = {
        "1": { min: 1, max: 9, minTie: -9 },
        "2": { min: 10, max: 99, minTie: -99 },
        "3": { min: 100, max: 999, minTie: -999 },
        "4": { min: 1000, max: 9999, minTie: -9999 },
        "5": { min: 10000, max: 99999, minTie: -99999 },
        "6": { min: 100000, max: 999999, minTie: -999999 },
        "7": { min: 1000000, max: 9999999, minTie: -9999999 },
        "8": { min: 10000000, max: 99999999, minTie: -99999999 },
        "9": { min: 100000000, max: 999999999, minTie: -999999999 },
      };

      function returnMaxDigit() {
        var digitsArray = [];
        var noOfDigits = $("#noOfDigits").val();
        if (noOfDigits) {
          digitsArray = noOfDigits.split(",");
          if (digitsArray.length > 1) {
            digitsArray.sort(function (a, b) {
              return b - a;
            });
          }
          maxNumberOfDigits = digitsArray[0];
        }
        return digitsMapping[maxNumberOfDigits];
      }

      function returnNumberOfRows() {
        maxNumberOfRows = $("#noOfRows").val();
        return parseInt(maxNumberOfRows);
      }

      function getRandomInt(index, digit, digitsArray) {
        var max, min;
        var tie = $("#tie").is(":checked");
        if (index === 0 || index === 1) {
          min = digit.min;
          max = digit.max;
          return generateRandomDigit(min, max);
        } else {
          min = digit.min;
          max = digit.max;
          tempRandomDigit = generateRandomDigit(min, max);
          tempRandomDigit *= Math.floor(Math.random() * 2) == 1 ? 1 : -1;
          digitsArraySum = digitsArray.reduce((a, b) => a + b, 0) + tempRandomDigit;
          if (digitsArraySum < 0) {
            return getRandomInt(index, digit, digitsArray);
          } else {
            return tempRandomDigit;
          }
        }
      }

      function generateRandomDigit(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
      }

      function generateString(maxDigit, noOfRows) {
        var returnString = "";
        var arrayForSum = [];
        for (var i = 0; i < noOfRows; i++) {
          var tempDigit = getRandomInt(i, maxDigit, arrayForSum);
          if (i === 0) {
            returnString = returnString + tempDigit.toLocaleString();
          } else if (i === 1) {
            returnString = returnString + "! + " + tempDigit.toLocaleString();
          } else {
            var sign = "+";
            if (arrayForSum[i - 1] >= 0 && tempDigit >= 0) {
              sign = " ";
            } else if (arrayForSum[i - 1] <= 0 && tempDigit <= 0) {
              sign = " ";
            } else {
              if (tempDigit > 0) {
                sign = "+";
              } else {
                sign = "-";
              }
            }
            if (arrayForSum[arrayForSum.length - 1] < 0 && tempDigit <= 0) {
              tempDigit = Math.abs(tempDigit);
              sign = "+";
            }
            returnString =
              returnString +
              "! " +
              sign +
              " " +
              Math.abs(tempDigit).toLocaleString();
          }

          arrayForSum.push(tempDigit);
        }
        console.log(arrayForSum);
        return {
          questionString: returnString,
          actualQuestionArray: arrayForSum,
          answerString: arrayForSum.reduce((a, b) => a + b, 0),
        };
      }

      $("#tie").click(function () {
        if ($(this).is(":checked")) {
          $("#totalNoOfDigitsContainer").show();
          $("#totalNoOfDigits").show();
        } else {
          $("#totalNoOfDigitsContainer").hide();
          $("#totalNoOfDigits").hide();
        }
      });

      function tieGenerateRandomDigit(min, max) {
        let number = Math.floor(Math.random() * (max - min + 1)) + min;
        if (number === 0) {
          return tieGenerateRandomDigit(min, max);
        }
        return number;
      }

      function tieGenerateRandomDigitRange(min, max) {
        "use strict";
        if (max < min) {
          // Swap min and max
          [min, max] = [min, max];
        }
        // Generate random number n, where min <= n <= max
        let range = max - min + 1;
        return Math.floor(Math.random() * range) + min;
      }

      function returnRes(numOfRows, maxNumofDigits, totalQDigits) {
        var res = [];
        for (let i = 0; i < numOfRows; i++) {
          res.push(tieGenerateRandomDigit(1, maxNumofDigits));
        }
        if (res.reduce((a, b) => a + b, 0) !== totalQDigits) {
          return returnRes(numOfRows, maxNumofDigits, totalQDigits);
        } else {
          return res;
        }
      }

      function returnResRange(
        numOfRows,
        minNumofDigits,
        maxNumofDigits,
        totalQDigits
      ) {
        var res = Array.from({ length: numOfRows }, () =>
          tieGenerateRandomDigitRange(minNumofDigits, maxNumofDigits)
        );
        if (res.reduce((a, b) => a + b, 0) !== totalQDigits) {
          return returnResRange(
            numOfRows,
            minNumofDigits,
            maxNumofDigits,
            totalQDigits
          );
        } else {
          return res;
        }
      }

      function generateStringForTie(digitsArray) {
        var returnString = "";
        var digitsArraySum = [];
        var testSign = [];
        var sign = "+";
        for (var i = 0; i < digitsArray.length; i++) {
          let min, max, maxDigitAllowed;
          maxDigitAllowed = Math.abs(digitsArray[i]);
          min = digitsMapping[maxDigitAllowed].min;
          max = digitsMapping[maxDigitAllowed].max;
          var tempRandomDigit = generateRandomDigit(min, max);
          if (i !== 0 && i !== 1) {
            tempRandomDigit *= Math.floor(Math.random() * 2) == 1 ? 1 : -1;
            if (
              digitsArraySum[digitsArraySum.length - 1] < 0 &&
              tempRandomDigit <= 0
            ) {
              tempRandomDigit = Math.abs(tempRandomDigit);
              sign = "+";
            }
          }
          var isDecimal = $("#isDecimal").is(":checked");
          if (isDecimal) {
            if (tempRandomDigit >= 10 && tempRandomDigit <= 99) {
              if (tempRandomDigit % 10 === 0) {
                tempRandomDigit = tempRandomDigit / 100;
              } else {
                tempRandomDigit = tempRandomDigit / 10;
              }
            } else if (tempRandomDigit >= 100 && tempRandomDigit <= 999) {
              if (tempRandomDigit % 100 === 0) {
                tempRandomDigit = tempRandomDigit / 1000;
              } else {
                tempRandomDigit = tempRandomDigit / 100;
              }
            } else if (tempRandomDigit >= 1000 && tempRandomDigit <= 9999) {
              if (tempRandomDigit % 1000 === 0) {
                tempRandomDigit = tempRandomDigit / 10000;
              } else {
                tempRandomDigit = tempRandomDigit / 1000;
              }
            } else if (tempRandomDigit >= 10000 && tempRandomDigit <= 99999) {
              if (tempRandomDigit % 10000 === 0) {
                tempRandomDigit = tempRandomDigit / 100000;
              } else {
                tempRandomDigit = tempRandomDigit / 10000;
              }
            }
          }
          digitsArraySum.push(tempRandomDigit);
          var digitsArrayTotalSum = digitsArraySum.reduce((a, b) => a + b, 0);
          if (digitsArrayTotalSum <= 0) {
            return generateStringForTie(digitsArray);
          }
        }
        var returnString = "";
        digitsArraySum.map(function (obj, i) {
          if (i === 0) {
            returnString = returnString + obj.toLocaleString();
          } else if (i === 1) {
            returnString = returnString + "! + " + obj.toLocaleString();
          } else {
            if (digitsArraySum[i - 1] >= 0 && obj >= 0) {
              sign = " ";
            } else if (digitsArraySum[i - 1] <= 0 && obj <= 0) {
              sign = " ";
            } else {
              if (obj >= 0) {
                sign = "+";
              } else {
                sign = "-";
              }
            }
            testSign.push(sign);
            returnString =
              returnString + "! " + sign + " " + Math.abs(obj).toLocaleString();
          }
        });
        return {
          questionString: returnString,
          actualQuestionArray: digitsArraySum,
          answerString: digitsArraySum.reduce((a, b) => a + b, 0),
          sign: testSign,
        };
        //}
      }

      $("#submit").click(function () {
          var numOfQuestions = $("#noOfQuestions").val();
          var questiontype = parseInt($('#question_type').val());
          var numOfRows = parseInt($('#noOfRows').val());
          var maxNumofDigits = parseInt($('#noOfDigits').val());
          var totalQDigits = parseInt($('#totalNoOfDigits').val());
          var no_of_set = parseInt($('#no_of_set').val());
          var jsonOfQuestions = [];
          for(var set = 1; set <= parseInt(no_of_set); set++)
          {
            for (var i = 1; i <= parseInt(numOfQuestions); i++) {
              var temp = {};
              var solution = generateString(returnMaxDigit(), returnNumberOfRows());
              temp["questionNumber"] = i;
              temp['setNumber'] = set;
              temp["actualQuestionArray"] = solution["actualQuestionArray"];
              temp["questionString"] = solution["questionString"];
              temp["answerString"] = solution["answerString"];
              jsonOfQuestions.push(temp);
            }
          }
          //Send this json to database
          console.log('rj1');

          var csrf_token = $('meta[name="csrf-token"]').attr('content');
          alert(csrf_token);
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
                type: 'POST',
                url: base_url+"/questionstore",
                data: { result: jsonOfQuestions, _token: csrf_token,no_of_rows: numOfRows,no_of_digits: maxNumofDigits,question_type: questiontype ,tie_val: tie,total_digit_in_Question: totalQDigits },
                dataType: 'json',
                success: function(response){
                    $('#dhtml').html(response.dthml);
                }
            });
          console.log(jsonOfQuestions);
      });
}

