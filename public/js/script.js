var champData;
var img;
var sumImg;
var summonerData;
var matches = {};
var id;
var username;

$(document).ready(function() 
{
	$('.materialboxed').materialbox();

	$(".alert.alert-danger")
	.css({
		'margin-top'		: '5px'
	}).find('li').css({
		'list-style-type'	: 'none'
	});

	var loc = window.location.pathname;
	loc =  loc.split('/');

	var count;
	var check;

	if (!loc[1]) 
	{
		$("#home").addClass('active');
	} else
	{
		$("#" + loc[1]).addClass('active');
	}
	
	$('#chatButton').on('click', function(e)
	{
		e.preventDefault();

		if ($('#textField').val() !== '') 
		{
			submitPost($('#textField').val());
		}
	})

	$('#searchForm').submit(function(e)
	{
		var val = $('#search-field').val();
		e.preventDefault();

		if (val !== '') 
		{
			search(val);
		};
	})

	$('#riotForm').submit(function(e)
	{
		var val = $('#search-field').val();
		e.preventDefault();

		if (val !== '') 
		{
			username = val;
			summonerData();
			championData();
		};
	})

	refresh();

	// $("#postContainer").animate({
	// 	scrollTop: $('#postContainer')[0].scrollHeight
	// }, 3000);

	var url = window.location.href;
	url = url.split('#');

	paginationBtn(url[1]);
	if (typeof pics !== 'undefined') 
	{
		loadImages(pics);
	};
	
	calendar();
})

function submitPost(post)
{
	$.ajax(
	{
		type: "GET",
		url: "/chat/post/" + id,
		data: post,

		success: function(data)
		{
			$('#textField').val('');
			refresh();
		}
	});
}

function refresh()
{
	$.ajax(
	{
		type: "GET",
		url: "/chat/refresh",

		success: function(data)
		{
			$("#postContainer > .row").html(data);
		}
	});
}

function search(data)
{
	$.ajax(
	{
		type: "GET",
		url: "/setSearch?" + data,

		success: function(data)
		{
			window.location.replace("search");
		}
	});
}

function deleteFunction(uid)
{
	$.ajax(
	{
		type: "GET",
		url: "/deleteId/" + uid,

		success: function()
		{
			location.reload();
		}
	});
}

function paginationBtn(url)
{

	$(".card").hide();
	url = url !== undefined ? url : 1;
	$('.pag.active').removeClass('active');
	$('#pag_' + url).addClass('active');

	showImages(url);
}

function loadImages(data)
{
	var lng = 1;
	$.each(data, function(index, pic){
		$("#card_" + lng + " > .card > .card-image").append("<img class='materialboxed s12 m12 l12' src='img/" + pic.image + "' height='300px'>");
		$("#card_" + lng + " > .card > .card-image").append("<span class='card-title'>" + pic.title + "</span>");
		$("#card_" + lng + " > .card > .card-content").html("<p>" + pic.desc + "</p>");
		lng++;
	});
}

function showImages(url)
{
	count = (url == 1 ? 1 : (url * 4) - 3);
	// if (url == 1) 
	// {
	// 	count = 1;
	// } else 
	// {
	// 	count = ;
	// }

	check = count + 3;
	
	for (var i = count; i <= check; i++) 
	{
		$("#card_" + i + " > .card").show();
	};
}

function calendar()
{
	var d = new Date();
	var count = 1;

	var days = getDays(d.getMonth());

	for (var i = 1; i < 7; i++)
	{
		$("#calendar").append("<tr id='nmb_" + i + "'></tr>");

		for (var r = 1; r <= 7; r++) {

			$("#nmb_" + i).append("<td>" + count + "</td>");

			if (count == days) 
			{
				count = 0;
			};

			count++;
		}
	}
}

function getDays(month)
{
	var days;
	switch(month)
	{
		case 0:
		//jan
			days = 31;
		break;
		case 1:
		//feb
			days = 28;
		break;
		case 2:
		//maart
			days = 31;
		break;
		case 3:
		//april
			days = 30;
		break;
		case 4:
		//mei
			days = 31;
		break;
		case 5:
		//juni
			days = 30;
		break;
		case 6:
		//juli
			days = 31;
		break;
		case 7:
		//aug
			days = 31;
		break;
		case 8:
		//sept
			days = 30;
		break;
		case 9:
		//okt
			days = 31;
		break;
		case 10:
		//nov
			days = 30;
		break;
		case 11:
		//dec
			days = 31;
		break;
	}

	return days;
}

function Riot()
{
	$.ajax(
	{
		type: "GET",
		url: "/riot/matchhistory/" + username,

		success: function(data)
		{
			loadData(data)
		}
	});
}

function championData()
{
	$.ajax(
	{
		type: "GET",
		url: "../js/champion.json",

		success: function(data)
		{
			champData = data;
			Riot();
		}
	});
}

function summonerData()
{
	$.ajax(
	{
		type: "GET",
		url: "../js/summoners.json",

		success: function(data)
		{
			summonerData = data;
		}
	});
}

function loadData(data)
{
	var i = 0;

	data = JSON.parse(data);
	$.each(data['matches'], function(index,value){
		getMatches(value['matchId'], i);
		i++;
	});

	loadMatches(matches);
}

function getKda(value)
{
	return (value["kills"] + value["assists"] / value["deaths"]).toFixed(2);
}

function loadChampImages(id, data)
{
	$.each(data, function(index, value)
	{
		if (value['key'] == id) 
		{
			return img = value['image']['full'];
		};
	});
}

function loadSummonerImages(id, data)
{
	var arr = [];

	$.each(data, function(index, value)
	{
		if (value['key'] == id['spell1Id']) 
		{
			arr['1'] = value['image']['full'];
		}else if(value['key'] == id['spell2Id'])
		{
			arr['2'] = value['image']['full'];
		};

	});
	return sumImg = arr;
}

function getMatches(data, val) 
{
	var limit = val;
	$.ajax(
	{
		type: "GET",
		url: "match/" + data,
		async: false,

		success: function(data)
		{
			matches[val] = JSON.parse(data);
		}
	});
}

function loadMatches (data)
{
	var i = 0;
	var winner;
	getId('ba');
	var partId = getParticipantId(data);
	console.log(partId);
	$.each(data, function(index, value)
	{
		console.log(value);
		loadChampImages(value['participants'][(partId[i] - 1)]['championId'], champData['data']);
		loadSummonerImages(value['participants'][(partId[i] - 1)], summonerData['data']);
		winner = value['participants'][(partId[i] - 1)]['stats']['winner'];
	
		$("#riotBody").append("<tr id='row_" + i + "'></tr>");
		$("#riotBody > #row_" + i).append("<td>" + (winner == true ? 'Win' : 'Loss') + "</td>");
		$("#riotBody > #row_" + i).append("<td><img src='http://ddragon.leagueoflegends.com/cdn/5.17.1/img/champion/" + img + "'></td>");
		$("#riotBody > #row_" + i).append("<td class='items'>");

		for (var r = 0; r < 7; r++) 
		{
			if (value['participants'][(partId[i] - 1)]['stats']['item' + r] == 0) 
			{
				$("#riotBody > #row_" + i + " .items").append("<img style='width:64px; height:64px'>");
			} else 
			{
				$("#riotBody > #row_" + i + " .items").append("<img src='http://ddragon.leagueoflegends.com/cdn/5.17.1/img/item/" + value['participants'][(partId[i] - 1)]['stats']['item' + r] + ".png'>");
			}
		};

		$("#riotBody > #row_" + i).append("<td><img src='http://ddragon.leagueoflegends.com/cdn/5.17.1/img/spell/" + sumImg[1]  + "'><img src='http://ddragon.leagueoflegends.com/cdn/5.17.1/img/spell/" + sumImg[2]  + "'></td>");
		$("#riotBody > #row_" + i).append("<td>" + getKda(value['participants'][(partId[i] - 1)]['stats']) + "</td>");
		i++;
	});
}

function getId(data) 
{
	$.ajax(
	{
		type: "GET",
		url: "id/" + username ,
		async: false,

		success: function(data)
		{
			id = data;
		}
	});
}

function getParticipantId(data)
{
	var partId = [];

	$.each(data, function(index,value)
	{
		$.each(value['participantIdentities'], function(key, participant)
		{
			if (participant['player']['summonerId'] == id) 
			{
				partId.push(participant['participantId']);
			};
		});
	});

	return partId;
}