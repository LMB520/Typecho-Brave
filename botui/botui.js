var botui = new BotUI("botui");
botui.message.bot({
    delay: 200,
    content: "hi，陌生人"
}).then(function() {
    return botui.message.bot({
        delay: 1000,
        content: "我们是杰杰＆安安"
    })
}).then(function() {
    return botui.message.bot({
        delay: 1000,
        content: "你想知道什么吗？"
    })
}).then(function() {
    return botui.action.button({
        delay: 1500,
        action: [{
                text: "想听故事",
                value: "xtgs"
            },
            {
                text: "我能干啥？",
                value: "wngs"
            },
            {
                text: "我想走了",
                value: "wxzl"
            }
        ]
    })
}).then(function(res) {
    if (res.value == "xtgs") {
        xtgs();
    }
    if (res.value == "wngs") {
        wngs();
    }
    if (res.value == "wxzl") {
        wxzl();
    }
});

function xtgs() {
    botui.message.bot({
        delay: 1500,
        content: "遇见即是缘分 拥有便是幸运"
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "我们初识于网络😋"
        });
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "遇见于学校🏫"
        });
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "我们既似知己🌈又似挚友🌈"
        });
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "我们也有很多共同点"
        });
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "每天给对方带来无限的快乐"
        });
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "于是，后来……"
        });
    }).then(function() {
        return botui.action.button({
            delay: 1500,
            action: [{
                text: "后来？",
                value: "hl"
            }]
        });
    }).then(function(res) {
        if (res.value == "hl") {
            hl();
        }
    });
}

function hl() {
    botui.message.bot({
        delay: 1500,
        content: "嘿嘿😋后来便是拥有的缘分啦~"
    }).then(function() {
        return botui.action.button({
            delay: 1500,
            action: [{
                    text: "我能干啥？",
                    value: "wngs"
                },
                {
                    text: "我想走了",
                    value: "wxzl"
                }
            ]
        });
    }).then(function(res) {
        if (res.value == "wngs") {
            wngs();
        }
        if (res.value == "wxzl") {
            wxzl();
        }
    });
}

function wngs() {
    botui.message.bot({
        delay: 1500,
        content: "祝福墙：可以写祝福给我们💌"
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "点点滴滴：可以查看关于我们的文章📖"
        });
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "关于我们：就是你所在的页面🎉"
        });
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "恋爱清单：听说完成100件事后，可以永远在一起📋"
        });
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "相册：能看好康的图片呀！📷"
        });
    }).then(function() {
        return botui.action.button({
            delay: 1500,
            action: [{
                    text: "想听故事",
                    value: "xtgs"
                },
                {
                    text: "我想走了",
                    value: "wxzl"
                }
            ]
        });
    }).then(function(res) {
        if (res.value == "xtgs") {
            xtgs();
        }
        if (res.value == "wxzl") {
            wxzl();
        }
    });
}

function wxzl() {
    botui.message.bot({
        delay: 1500,
        content: "好哒，欢迎下次光临！Bye~"
    }).then(function() {
        return botui.message.bot({
            delay: 1500,
            content: "本次对话已结束🔚"
        });
    });
}