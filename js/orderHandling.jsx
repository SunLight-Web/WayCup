    /** @jsx React.DOM */   
        var clientHandler = React.createClass({
	    	getInitialState: function(){
	    		return { name: '', coffees: 0, bonuses: 0, cardnum : 0 };
	    	},

            onChangeHandle: function(e){
                this.submitHandle(e);
            },

	    	submitHandle: function(e){
	    		e.preventDefault();
	    		var cardnum = this.refs.cardnum.getDOMNode().value.trim();
	    		var query = 'cardProceed.php?cardnum=' + cardnum;
	    		    $.get(query, function(result) {
	    		    	var client = jQuery.parseJSON(result);
	    		    	if (!client.noElements){
	    		    		this.setState({name: client.name, coffees: client.coffees, bonuses: client.bonuses, noBonuses: client.noBonuses, cardnum: cardnum});
	    		    	}
				    }.bind(this));
	    	},
            componentDidMount: function(e){
                this.onChangeHandle(e);
            },
	    	render: function(){
	    		var clientsNameDiv;
	    		var bonusInfo;
		    	if (this.state.noBonuses) {
		    		bonusInfo = <strong>Бонусов нет</strong>
		    	} else {
		    		bonusInfo = <div>Текущее количество бонусов: <strong>{this.state.bonuses}</strong></div>
		    	}

	    		if (this.state.name == '') {
					clientsNameDiv = <div>Видимо, такого клиента у нас нет</div>
	    		} else {
	    			clientsNameDiv = <div>Клиента зовут <strong>{this.state.name}</strong>.</div>
	    		}
	    		return (
<<<<<<< HEAD
                    <div className="menu-info-client">
                    <div className="form-card-info">
	    				<form id="clientForm" onSubmit={this.submitHandle}>
	    					<label htmlFor="cardnumInput"><strong>Номер карты:</strong></label>
=======
	    		<div className="menu-info-client">
	    		

	    			<div className="form-card-info">
	    				<form id="clientForm" onSubmit={this.submitHandle}>
<<<<<<< HEAD
	    					<label htmlFor="cardnumInput">Номер карты:</label>
>>>>>>> FETCH_HEAD
                            <input type="number" min="0" onChange={this.onChangeHandle} inputmode="numeric" pattern="[0-9]*" ref='cardnum' maxLength="4"/> <br/>
=======
	    					<label htmlFor="cardnumInput"><strong>Номер карты:</strong></label>
	    					<input type="text" id="cardnumInput" onchange={this.submitHandle} ref='cardnum' maxLength="4"/> <br/>
>>>>>>> front
	    				</form>
	    			</div>

                    <div className="info-about-client-card">
	    			{clientsNameDiv}

					Человек купил у нас <strong>{this.state.coffees}</strong> кофе.
	    			<br/>
	    			{bonusInfo}
                    </div>
                    <div className="clear"></div>

<<<<<<< HEAD
=======

>>>>>>> FETCH_HEAD
	    			<menuAndOrder cardnum={this.state.cardnum}/>
                    


	    		</div>
	    		);
	    	}


    });

    var categorySeparator = React.createClass({
        render: function(){
        }
    });
    var menuElement = React.createClass({

    	clickHandler: function(){
    	
    		 this.props.onClick(this.props.ref);
    	},

    	render: function(){
 			var isLiquid;
 			if (this.props.category == '1') {isLiquid = 'мл'} else {isLiquid = 'шт'};
    		return (
    				<li onClick={this.clickHandler}>
	    				<span>{this.props.name}</span><strong>{this.props.quanity}</strong>
	    				<br/>
						{this.props.amount}{isLiquid} 
	    				<br/>
	    				<i>{this.props.price}₽</i>
	    				
    				</li>
    			);
    	}

    });

    var menuAndOrder = React.createClass({

        getInitialState: function(){
            return { total: 0, menuElements: [], orderElements: [], menuCategories: []};
        },
        
        kEbenyam: function(){
        	var menuElements = this.state.menuElements;
       		menuElements.map(function(e){
       			e.quanity = 0
       		});
        	this.setState({menuElements: menuElements, orderElements: [], total: 0 });
        	document.getElementById('cardnumInput').value = '';
        },

        proceed: function(){
        	var orderElements = this.state.orderElements;
	        	if (confirm('Уверен вообще?')) {
	        		var toParse = [];
	        		var idset = [];    		
		            var cash;
		            var coffees = 0;
		            var cardnum = this.props.cardnum;
		        	if (orderElements.length != 0) {
			            for (var i = 0; i < orderElements.length; i++) {
							idset += '.' + orderElements[i].id;
							while (orderElements[i].quanity != 1){
                                if (orderElements[i].category == 1){
                                    coffees++;
                                }
								idset += '.' + orderElements[i].id;
								orderElements[i].quanity--;

							}
							if (orderElements[i].category == 1){
								coffees++;
							}
		                }
		            idset = idset.substring(1);
		            }

	                cash = this.state.total;
	                toParse = {cardnum: cardnum, idset:idset, cash:cash, coffees:coffees};
	                

					$.post( "checkandsave.php", toParse, function(data) {
						var tooltip;
						var text;
						text 	= document.getElementById('tooltipText');
						tooltip = document.getElementById('tooltip');
						tooltip.style.display = 'inline';
						text.innerHTML = data;
					});
        		this.kEbenyam();
        	}
        },

        componentDidMount: function(){ 
            var self = this;
            var url  = 'getJsonMenu.php';
            $.getJSON(url, function(result){
                console.log(result);
                elements   = result.elements;
                categories = result.categories;
            if(!elements || !elements.length){
                return;
            }

                var menuElements = elements.map(function(p){
                    return {
                        id: p.id,
                        name: p.name,
                        price: p.price,
                        amount: p.amount,
                        category: p.category,
                        quanity: 0
                    };
                });
                var menuCategories = categories.map(function(c){
                    return {
                        id:   c.id,
                        name: c.name
                    };
                });
                self.setState({ menuElements: menuElements, menuCategories: menuCategories });
            });
        },

        menuElementClick: function(id){

            var orderElements	  = this.state.orderElements,
                menuElements      = this.state.menuElements,
                total			  = this.state.total,
                inOrdersAlready	  = false;

            for (var i = 0; i < orderElements.length; i++) {
                if (orderElements[i].id == id) {
                		inOrdersAlready = true;
                    break;
                }
            }

            for (var i = 0; i < menuElements.length; i++) {
                if (menuElements[i].id == id) {
                	menuElements[i].quanity +=1;
                	if (!inOrdersAlready){
                   		orderElements.push(menuElements[i]);
                	}
                	total += Number(menuElements[i].price);
                    break;
                }
            }

            this.setState({menuElements: menuElements, orderElements: orderElements, total: total});
        },

        orderElementClick: function(id){
            var orderElements = this.state.orderElements,
                menuElements  = this.state.menuElements,
                total		  = this.state.total;

            for (var i = 0; i < orderElements.length; i++) {
                if (orderElements[i].id == id) {
                	total -= Number(orderElements[i].price);
                	orderElements[i].quanity -= 1;
                	if (orderElements[i].quanity == 0){
                		orderElements.splice(i, 1);
                	} 
                	break;
            	}
            }
            this.setState({menuElements: menuElements, orderElements: orderElements, total: total});

        },

        render: function(){

            var self = this;
            var menuCategories   = this.state.menuCategories;
            var menuElements     = this.state.menuElements;
                menuElements     = menuElements.map(function(s){
                    return <menuElement ref={s.id} name={s.name} price={s.price} category={s.category} amount={s.amount} onClick={self.menuElementClick} />;
                });
                
                var cats = [];
                menuCategories.forEach(function(c){
                    cats.push(new Array());
                    cats[c.id-1].push(<div className="category-separator"><br/><h5>{c.name}</h5><br/></div>);
                        menuElements.forEach(function(e){
                            if (c.id == e.props.category) {
                                cats[c.id-1].push(e);
                            }
                        });
                    });

               
            if(!menuElements.length){
                menuElements = <div><br/><br/><p>Загрузка данных с сервера...</p></div>;
            }

            var orderElements = this.state.orderElements.map(function(s){
                return <menuElement ref={s.id} name={s.name} price={(s.price*s.quanity).toFixed(2)} category={s.category} amount={s.amount} quanity={s.quanity} onClick={self.orderElementClick} />;
            });

            if(!orderElements.length){
                orderElements = <div className="order-war"><i>Сформируйте заказ</i></div>;
<<<<<<< HEAD

=======
>>>>>>> FETCH_HEAD
            }
            return (
                <div>
                    <div className="menu-items">
<<<<<<< HEAD

=======
<<<<<<< HEAD
                        <h3>Меню</h3>
=======
>>>>>>> front
>>>>>>> FETCH_HEAD
                        <ul id="list-of-items-in-stock">
                            {cats}
                        </ul>
                        <div className="clear"></div>
                    </div>

                    <div className="order">
                        <h3 className="main-title">Заказ</h3> 
<<<<<<< HEAD
=======

>>>>>>> FETCH_HEAD
                        <ul id="order-list">
                        	{orderElements}
                            <div className="clear"></div>
                        </ul>
<<<<<<< HEAD

                        <strong>Сумма заказа: {this.state.total.toFixed(2)} ₽</strong>
=======
                        
                        
                        <strong>Сумма заказа: {this.state.total.toFixed(2)} ₽</strong>
                        
>>>>>>> FETCH_HEAD
                       <div className="order-buttons">
                        <button onClick={this.kEbenyam}>Очистить заказ</button>
                        <button onClick={this.proceed}>Подтвердить</button>
                       </div>
<<<<<<< HEAD
=======
                       
>>>>>>> FETCH_HEAD
                    </div>
                </div>
            );
        }
    });


        React.renderComponent(
        <clientHandler/>,
        document.getElementById('menu-react-mount')

    );