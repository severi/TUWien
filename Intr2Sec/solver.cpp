#include <iostream>
#include <string>
#include <sstream>
#include <fstream>
#include <vector>
#include <bitset>

using namespace std;



void str2IntVec(vector<int>& vec,const  string& str){
	for (int i=0; i<str.length();){
		char t1 = str[i++];
		char t2 = str[i++];
		int a;		
		stringstream ss;
		ss<<hex<<t1<<t2;
		ss>>a;
		vec.push_back(a);
		//cout << "INT " <<a<<endl;
		//cout << "HEX " << hex<< a<<endl;
		//cout << "ASC " << char(a)<<endl<<endl;
	}	
	
}

string doTheMagic(const vector<int>& vec1, const vector<int>& vec2){
	vector<int>::const_iterator it1 = vec1.begin();
	vector<int>::const_iterator it2 = vec2.begin();

	stringstream ss;

	while (it1!=vec1.end() && it2!=vec2.end()){
		int h = (*it1)^(*it2);
		
		/*
		bitset<8> test1(*it2);
		bitset<8> test2(*it1);
		bitset<8> test(h);
		cout<<test1<<endl;
		cout<<test2<<endl;
		cout<<"--------"<<endl;
		cout<<test<<endl<<endl;
		*/

		it1++;
		it2++;
		if (h<16)ss<<"0";
		ss<<hex<<h;
	}
	return ss.str();
}

string xorStrings(const string& msg,const  string& inp){
//	string msg = "6162636465";
	vector<int> msgInt;
	vector<int> inpInt;
	str2IntVec(msgInt, msg);
	str2IntVec(inpInt, inp);
//	for (vector<int>::reverse_iterator i=msgInt.rbegin();i!=msgInt.rend();i++){
//		cout << char(*i)<<endl;
//		break;
//	}
	
	return doTheMagic(msgInt,inpInt);
}





int main()
{
	ifstream msg1("tmp1.txt");
	string msg;
	msg1>>msg;
	msg1.close();

	vector<string> inputs;
	ifstream inp("tmp2.txt");
	string tmpInp;
	while (inp>>tmpInp) {
		inputs.push_back(tmpInp);
	//	cout<<tmpInp<<endl;
	}
	vector<string> xorStr;
	
	int i=0;
	int j=0;
	for (vector<string>::iterator iter = inputs.begin(); iter!=inputs.end();++iter){
		xorStr.push_back(xorStrings(msg,*iter));
	}
	cout << xorStr[0]<<endl;
	return 0;
}

