//
//  main.cpp
//  CommandLineTestApplication
//
//  Created by Gibo on 2015. 8. 13..
//  Copyright (c) 2015년 Gibo. All rights reserved.
//
#include <iostream>
#include <string>
#include <map>
#include <vector>
#include <algorithm>

const static int kColumnCount = 5;

class Word {

public:

	Word(char Text)
		: _Text(Text)
	{

	}

	static std::vector<int> GetAroundIdx(int TargetIdx)
	{
		std::vector<int> AroundIdxs;

		for (int i = 0; i<8; i++)
		{
			AroundIdxs.push_back(TargetIdx - 6);
			AroundIdxs.push_back(TargetIdx - 5);
			AroundIdxs.push_back(TargetIdx - 4);
			AroundIdxs.push_back(TargetIdx - 1);
			AroundIdxs.push_back(TargetIdx + 1);
			AroundIdxs.push_back(TargetIdx + 4);
			AroundIdxs.push_back(TargetIdx + 5);
			AroundIdxs.push_back(TargetIdx + 6);
		}

		return AroundIdxs;
	}

	static std::vector<Word *> CreateWordArray(std::vector<std::string> InsertedWords)
	{
		std::vector<Word *> WordArray;

		for (int i = 0; i<kColumnCount; i++)
		{
			InsertedWords[i];
			for (int j = 0; j<kColumnCount; j++)
			{
				auto OneWord = InsertedWords[i].at(j);
				auto CreatedWord = new Word(OneWord);
				WordArray.push_back(CreatedWord);
			}
		}
		for (int i = 0; i<WordArray.size(); i++)
		{
			auto AroundIdxs = GetAroundIdx(i);
			for (auto AroundIdx : AroundIdxs)
			{
				if (AroundIdx < 0 || AroundIdx >= WordArray.size())
				{
					continue;
				}
				WordArray[i]->AddAroundWord(WordArray[AroundIdx]);
			}
		}

		return WordArray;
	}

	const Word *FindConnectedWord(const char TargetText) const
	{
		auto FoundItr = std::find_if(_AroundWords.begin(), _AroundWords.end(), [&, TargetText](const Word *MembetWord)->bool{
			return MembetWord->GetText() == TargetText;
		});

		if (FoundItr == _AroundWords.end())
		{
			return nullptr;
		}

		return *FoundItr;
	}

	const char GetText() const { return _Text; }
	void AddAroundWord(Word *AddWord)
	{
		_AroundWords.push_back(AddWord);
	}

private:

	const char _Text;
	std::vector<Word *> _AroundWords;

};

int main()
{
	unsigned int TestCaseCount = 0;

	std::vector<Word *> WordList;
	std::vector<std::string> InputString;

	std::cin >> TestCaseCount;
	for (int i = 0; i<kColumnCount; i++)
	{
		std::string LineString;
		std::cin >> LineString;
		InputString.push_back(LineString);
	}

	int FindWordCount = 0;

	auto WordArray = Word::CreateWordArray(InputString);

	std::cin >> FindWordCount;

	std::vector<std::tuple<std::string, bool>> FindString;

	for (int i = 0; i<FindWordCount; i++)
	{
		std::string LineString;
		std::cin >> LineString;
		FindString.push_back(std::make_tuple(LineString, false));
	}

	for (auto &FindOneString : FindString)
	{
		auto FindWordString = std::get<0>(FindOneString);
		auto FindChar = FindWordString[0];
		std::for_each(WordArray.begin(), WordArray.end(), [&, FindChar](const Word *MemberWord){
			if (MemberWord->GetText() != FindChar)
			{
				return;
			}
			const Word *FoundWord = MemberWord;

			int i = 0;
			while (FoundWord != nullptr)
			{
				if (i + 1 == FindWordString.length())
				{
					std::get<1>(FindOneString) = true;
					break;
				}
				char a = FindWordString[i + 1];
				FoundWord = FoundWord->FindConnectedWord(a);
				i++;
			}
		});
	}

	for (auto ResultStr : FindString)
	{
		std::cout << std::get<0>(ResultStr) << " : ";
		if (std::get<1>(ResultStr))
		{
			std::cout << "YES";
		}
		else
		{
			std::cout << "NO";
		}
		std::cout << std::endl;
	}

	return 0;
}
