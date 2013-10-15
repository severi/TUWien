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

vector<int> doTheMagic(const vector<int>& vec1, const vector<int>& vec2){
	vector<int>::const_iterator it1 = vec1.begin();
	vector<int>::const_iterator it2 = vec2.begin();

	vector<int> ret;
	while (it1!=vec1.end() && it2!=vec2.end()){
		ret.push_back( (*it1)^(*it2) );
				

		it1++;
		it2++;
	}
	return ret;
}


vector<int> xorStrings(const string& msg,const  string& inp){
	vector<int> msgInt;
	vector<int> inpInt;
	str2IntVec(msgInt, msg);
	str2IntVec(inpInt, inp);
	
	return doTheMagic(msgInt,inpInt);
}
/*
void findSpaces(const vector<string>& vec){
	int space = 0x20;
	for (vector<int>::const_iterator it = vec.begin(); it!=vec.end();it++){
		if ((*it)^space==0) cout<<"HEP"<<endl;
	}
}
*/
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
	inp.close();

	vector< vector<int> > xorStr;
	
	int i=0;
	int j=0;
	for (vector<string>::iterator iter = inputs.begin(); iter!=inputs.end();++iter){
		xorStr.push_back(xorStrings(msg,*iter));
	}
	
	for (vector<int>::iterator v=xorStr[0].begin();v!=xorStr[0].end();v++){
		cout<<hex<<(*v)<<endl;

	}
	
	//findSpaces(xorStr);
	
	return 0;
}

