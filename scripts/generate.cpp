#include <iostream>
#include <vector>
#include <set>
#include <cstdio>
#include <cstring>
#include <cstdlib>
#include <ctime>

using namespace std;

char buffer[1024];
char boolean[2][10] = {"false", "true"};

// Lists with names of objects
vector <string> planetarySystems_list;
vector <string> planets_list;
vector <string> stars_list;
vector <string> moons_list;

// Resulting queries for objects
vector <string> spaceObject_result;
vector <string> planetarySystems_result;
vector <string> planets_result;
vector <string> stars_result;
vector <string> moons_result;

void move_strptr(char*& ptr) {
 	while (*ptr)
 		ptr++;
}

string generate_random_string(int length) {
 	string result;

 	int nlength = rand() % length + 1;

 	for (int i = 0; i < nlength; i++) {
 	 	result.append(1, rand() % 26 + 'a');
 	}

 	static set <string> result_set;
 	if (result_set.find(result) != result_set.end())
 		return generate_random_string(length);
 	
 	result_set.insert(result);
 	return result;
}

void generate_lists() {
 	srand(time(NULL));
 	
 	for (int i = 0; i < 5; i++) {
 	 	planetarySystems_list.push_back(generate_random_string(10));
 	}

 	for (int i = 0; i < 20; i++) {
 	 	planets_list.push_back(generate_random_string(10));
 	}

 	for (int i = 0; i < 20; i++) {
 	 	stars_list.push_back(generate_random_string(10));
 	}

 	for (int i = 0; i < 10; i++) {                        	
 	 	moons_list.push_back(generate_random_string(10));
 	}
}

void strcopy(char*& dest, const char *source) {
 	strcpy(dest, source);
 	move_strptr(dest);
}

void generate_queries() {
 	for (size_t i = 0; i < stars_list.size(); i++) {
 		char* buffptr = buffer;

 		strcopy(buffptr, "INSERT INTO spaceObject(name, radius, mass, EarthDistance, age, rotationSpeed, galaxyName, galaxyType, ownerID) VALUES('");
 		strcopy(buffptr, stars_list[i].c_str());
 		strcopy(buffptr, "'");

 		for (int j = 0; j < 5; j++) {
 		 	sprintf(buffptr, ", %d", rand() % 100 + 1);
 		 	move_strptr(buffptr);
 		}

 		strcopy(buffptr, ", '");
 		strcopy(buffptr, generate_random_string(15).c_str());
 		strcopy(buffptr, "', '");
 		strcopy(buffptr, generate_random_string(15).c_str());
 		strcopy(buffptr, "', 1);\n");

 		spaceObject_result.push_back(string(buffer));

		buffptr = buffer;
 		strcopy(buffptr, "INSERT INTO star(OName, starType, color) VALUES('");
 		strcopy(buffptr, stars_list[i].c_str());
 		strcopy(buffptr, "', '");
 		strcopy(buffptr, generate_random_string(10).c_str());
 		strcopy(buffptr, "', '");
 		strcopy(buffptr, generate_random_string(10).c_str());
 		strcopy(buffptr, "');\n");
 		
 		stars_result.push_back(string(buffer));
 	}

 	for (int i = 0; i < 5; i++) {
 	 	char *buffptr = buffer;

 	 	strcopy(buffptr, "INSERT INTO planetarySystem(name, starName, description) VALUES('");
 	 	strcopy(buffptr, planetarySystems_list[i].c_str());
 	 	strcopy(buffptr, "', '");
 	 	strcopy(buffptr, stars_list[i].c_str());
 	 	strcopy(buffptr, "', '");
 	 	strcopy(buffptr, generate_random_string(100).c_str());
 	 	strcopy(buffptr, "');\n");
 	 	planetarySystems_result.push_back(string(buffer));
 	}

 	for (size_t i = 0; i < planets_list.size(); i++) {
 		char* buffptr = buffer;

 		strcopy(buffptr, "INSERT INTO spaceObject(name, radius, mass, EarthDistance, age, rotationSpeed, galaxyName, galaxyType, ownerID) VALUES('");
 		strcopy(buffptr, planets_list[i].c_str());
 		strcopy(buffptr, "'");

 		for (int j = 0; j < 5; j++) {
 		 	sprintf(buffptr, ", %d", rand() % 100 + 1);
 		 	move_strptr(buffptr);
 		}

 		strcopy(buffptr, ", '");
 		strcopy(buffptr, generate_random_string(15).c_str());
 		strcopy(buffptr, "', '");
 		strcopy(buffptr, generate_random_string(15).c_str());
 		strcopy(buffptr, "', 1);\n");

 		spaceObject_result.push_back(string(buffer));

		buffptr = buffer;
 		strcopy(buffptr, "INSERT INTO planet(OName, isLiveable, hasWater, hasAtmosphere, planetarySystemName) VALUES('");
 		strcopy(buffptr, planets_list[i].c_str());
 		strcopy(buffptr, "'");
 		
 		for (int j = 0; j < 3; j++) {
 			strcopy(buffptr, ", ");
 			strcopy(buffptr, boolean[rand() & 1]);
 		}

 		strcopy(buffptr, ", '");
 		strcopy(buffptr, planetarySystems_list[rand() % planetarySystems_list.size()].c_str());
 		strcopy(buffptr, "');\n");
 		
 		planets_result.push_back(string(buffer));
 	}

 	for (size_t i = 0; i < moons_list.size(); i++) {
 		char* buffptr = buffer;

 		strcopy(buffptr, "INSERT INTO moon(name, PName) VALUES ('");
 		strcopy(buffptr, moons_list[i].c_str());
 		strcopy(buffptr, "', '");
 		strcopy(buffptr, planets_list[rand() % planets_list.size()].c_str());
 		strcopy(buffptr, "');\n");

 		moons_result.push_back(string(buffer));
 	}
}

void print_vector_string(const vector <string>& vec) {
	for (size_t i = 0; i < vec.size(); i++) {
		printf("%s", vec[i].c_str());
	}
	printf("\n");
}

void print_queries() {
	freopen("temp.sql", "w", stdout);

	print_vector_string(spaceObject_result);
	print_vector_string(stars_result);
	print_vector_string(planetarySystems_result);
	print_vector_string(planets_result);
	print_vector_string(moons_result);
}

int main() {
	generate_lists();

	generate_queries();

	print_queries();
	
	return 0;
}
	