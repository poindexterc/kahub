(function (A) {
    A.extend(A.fn, {
        pstrength: function (B) {
            var B = A.extend({
                verdects: ["", "", "", "", ""],
                colors: ["#C33", "#6EC02A", "#6EC02A", "#6EC02A", "#6EC02A"],
                scores: [10, 15, 30, 40],
                common: ["password", "sex", "god", "123456", "123", "liverpool", "letmein", "qwerty", "monkey", "1234567", "pass", "1234567890", "pAsSSworD", "passworD", "12345678", "123456789", "111111", "222222", "333333", "444444", "555555", "666666", "777777", "888888", "999999", "000000", "1111111", "2222222", "3333333", "4444444", "5555555", "6666666", "7777777", "8888888", "9999999", "0000000"],
                minchar: 6
            }, B);
            return this.each(function () {
                var C = A(this).attr("id");
                A(this).after("<div class=\"pstrength-info\" id=\"" + C + "_text\"></div>");
                A(this).after("<div class=\"pstrength-bar\" id=\"" + C + "_bar\" style=\"border-right: 195px solid white;border-left: 1px solid white;border-top: 1px solid white;border-bottom: 1px solid white; font-size: 1px; height: 5px; width: 0px;\"></div>");
                A(this).keyup(function () {
                    A.fn.runPassword(A("#password").val(), C, B)
                })
            })
        },
        runPassword: function (D, F, C) {
            nPerc = A.fn.checkPassword(D, C);
            var B = "#" + F + "_bar";
            var E = "#" + F + "_text";
            if (nPerc == -200) {
                strColor = "#f00";
                strText = "Really? No.";
                A(B).css({
                    borderRight: '179px solid #fff',
					width: "10%"
                })
            } else {
                if (nPerc < 0 && nPerc > -199) {
                    strColor = "#ccc";
                    strText = "";
                    A(B).css({
                        borderRight: '157px solid #fff',
						width: "20%"
                    })
                } else {
                    if (nPerc <= C.scores[0]) {
                        strColor = C.colors[0];
                        strText = C.verdects[0];
                        A(B).css({
                             borderRight: '140px solid #fff',
							width: "30%"
                        })
                    } else {
                        if (nPerc > C.scores[0] && nPerc <= C.scores[1]) {
                            strColor = C.colors[1];
                            strText = C.verdects[1];
                            A(B).css({
                                borderRight: '89px solid #fff',
								width: "40%"
                            })
                        } else {
                            if (nPerc > C.scores[1] && nPerc <= C.scores[2]) {
                                strColor = C.colors[2];
                                strText = C.verdects[2];
                                A(B).css({
                                    borderRight: '75px solid #fff',
									width: "60%"
                                })
                            } else {
                                if (nPerc > C.scores[2] && nPerc <= C.scores[3]) {
                                    strColor = C.colors[3];
                                    strText = C.verdects[3];
                                    A(B).css({
                                         borderRight: '57px solid #fff',
										width: "70%"
                                    })
                                } else {
                                    strColor = C.colors[4];
                                    strText = C.verdects[4];
                                    A(B).css({
                                         borderRight: '0px solid #fff',
										width: "97%"
                                    })
                                }
                            }
                        }
                    }
                }
            }
            A(B).css({
                backgroundColor: strColor
            });
            A(E).html("<span id='verdict' style='color: " + strColor + ";'>" + strText + "</span>")
        },
        checkPassword: function (C, B) {
            var F = 0;
            var E = B.verdects[0];
			for (var D = 0; D < B.common.length; D++) {
                if (C.toLowerCase() == B.common[D]) {
                    F = -200
					console.log("10");
					console.log(D);
                }
            }

            if (C.length < B.minchar) {
                F = (F - 100)
            } else {
                if (C.length >= B.minchar && C.length <= (B.minchar + 2)) {
                    F = (F + 6)
					console.log("A");
					console.log(F);
                } else {
                    if (C.length >= (B.minchar + 3) && C.length <= (B.minchar + 4)) {
                        F = (F + 12)
						console.log("B");
						console.log(F);
                    } else {
                        if (C.length >= (B.minchar + 5)) {
                            F = (F + 18)
							console.log("C");
							console.log(F);
                        }
                    }
                }
            }
            if (C.match(/[A-Z]/)) {
                F = (F + 5)
				console.log("2");
				console.log(F);
            }
            if (C.match(/\d+/)) {
                F = (F + 3)
				console.log("3");
				console.log(C);
            }
            if (C.match(/(.*[0-9].*[0-9].*[0-9])/)) {
                F = (F + 7)
				console.log("4");
				console.log(F);
            }
            if (C.match(/.[!,@,#,$,%,^,&,*,?,_,~]/)) {
                F = (F + 10)
				console.log("5");
				console.log(F);
            }
            if (C.match(/(.*[!,@,#,$,%,^,&,*,?,_,~].*[!,@,#,$,%,^,&,*,?,_,~])/)) {
                F = (F + 7)
				console.log("6");
				console.log(F);
            }
            if (C.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
                F = (F + 2)
				console.log("7");
				console.log(F);
            }
            if (C.match(/([a-zA-Z])/) && C.match(/([0-9])/)) {
                F = (F + 3)
				console.log("8");
				console.log(F);
            }
            if (C.match(/([a-zA-Z0-9].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z0-9])/)) {
                F = (F + 3)
				console.log("9");
				console.log(F);
            }
            for (var D = 0; D < B.common.length; D++) {
                if (C.toLowerCase() == B.common[D]) {
                    F = -200
					console.log("10");
					console.log(D);
                }
            }
			
            return F
        }
    })
})(jQuery)