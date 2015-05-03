# phpCache
PHP files Cache, Simple, Easy and Fast Files Cache

# How to use ?
##### include class

	include('Cache/Cache.php');

##### to set chaced data, use set function to do that, first argument the name of cache data and the second argument the value

	Cache::set('age', 35);
	
	Cache::set('data', ['id'=>100, 'name'=>'ahmed','email'=>'ahmedsaoud31@gmail.com']);

##### to get data from cache use get function

	$age = Cache::get('age');
	
	$data = Cache::get('data');

##### to cache data with time, use function set with 3 arguments the thread argument is time in minuets
##### save cache data for one day

	Cache::set('age', 100, 24*60);
	
	$data = ['id'=>100, 'name'=>'ahmed','email'=>'ahmedsaoud31@gmail.com'];
	
	Cache::set('data', $data, 24*60);


##### you can cache string, boolean, numbers, arrays and objects

	$obj = new stdClass();
	
	$obj->id = 200;
	
	$obj->name = 'Ahmed';
	
	$obj->email = 'ahmedsaoud31@gmail.com';
	
	Cache::set('obj', $obj);
	
	Cache::set('sign', true);
	
	Cache::set('num', 2015);
	
	Cache::set('arr', [1,2,3,4]);
	
	Cache::set('str', 'ahmed');

##### to save cached data forever, keep time argument empty like

	Cache::set('name', 'ahmed');

##### to delete cached data use function delete

	Cache::delete('data');

##### if you want to delete more than one in one line pass names as array like this

	Cache::delete(['data','age','obj']);

##### if you want delete all Cached data you can use delete function without any arguments like

	Cache::delete();

##### if you want to check if cached value is set or not use has function has

	if(Cache::has('age'))
		echo Cache::get('age');
	
##### Have a nice Caching :)

# طريقة الإستخدام
##### قم بتضمين الفئة

	include('Cache/Cache.php');

##### لحفظ البيانات إستخدم الدالة  
##### set 
##### الوسيط الأول عبارة عن الاسم والوسيط الثاني هو للقيمة والثالث إختياري للوقت

	Cache::set('age', 35);
	
	Cache::set('data', ['id'=>100, 'name'=>'ahmed','email'=>'ahmedsaoud31@gmail.com']);

##### لجلب البيانات المحفوظة مسبقاً إستخدم الدالة 
##### get

	$age = Cache::get('age');
	
	$data = Cache::get('data');

##### لحفظ البيانات لوقت محدد يمكنك إستخدام الدالة 
##### set 
#####مع وضع الزمن المراد حذف البيانات بعده كوسيط ثالث للدالة بالدقائق
##### المثال التالي لحفظ البيانات لمدة يوم واحد

	Cache::set('age', 100, 24*60);
	
	$data = ['id'=>100, 'name'=>'ahmed','email'=>'ahmedsaoud31@gmail.com'];
	
	Cache::set('data', $data, 24*60);


##### يمكنك تخزين بيانات مختلفة كـ سلاسل نصية، مصفوفات، قيم منطقية، أرقام وكائنات

	$obj = new stdClass();
	
	$obj->id = 200;
	
	$obj->name = 'Ahmed';
	
	$obj->email = 'ahmedsaoud31@gmail.com';
	
	Cache::set('obj', $obj);
	
	Cache::set('sign', true);
	
	Cache::set('num', 2015);
	
	Cache::set('arr', [1,2,3,4]);
	
	Cache::set('str', 'ahmed');

##### لحفظ البيانات للأبد، إترك الوسيط الثالث الخاص بالوقت للدالة 
##### set 
##### فارغاً

	Cache::set('name', 'ahmed');

##### لحذف قيمة مخزنة إستخدم الدالة  
##### delete

	Cache::delete('data');

##### لحذف مجموعة قيم دفعة واحدة قم بتمرير اسماء القيم داخل مصفوفة كوسيط لنفس الدالة 
##### delete

	Cache::delete(['data','age','obj']);

#### إذا أردت حذف جميع البيانات المخزنة يمكنك إستخدام نفس الدالة 
##### delete 
##### بدون أي وسائط

	Cache::delete();

#### إذا أردت التحقق من وجود قيمة مخزنة مسبقاً أم لا إستخدم الدالة 
##### has

	if(Cache::has('age'))
		echo Cache::get('age');
	
### تخزين سعيد :)

